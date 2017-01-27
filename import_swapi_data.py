import requests
import os
import pickle
from urllib.parse import urlparse,urlunparse
from pymongo import MongoClient
from bson.objectid import ObjectId


SWAPI_ROOT = "http://swapi.co/api/"

# e.g. MONGODB_URI => mongodb://user:randpass@host:port/dbname
db_url = urlparse(os.getenv("DATABASE_URL"))

MONGODB_URI = urlunparse(db_url[0:6])
MONGODB_NAME=db_url.path.replace("/", "")


def fetch_all_resources_for(*resource):
    resource_name, url = resource #Expect tuple

    # TODO: something around limits and the API pagination total 'count'

    resources = {}
    while url:
        # Optional: helpful while debuggin pagination.
        #print("\tGET {}".format(url))

        response = requests.get(url)
        if response.status_code != 200:
            print('Error with status code {}'.format(response.status_code))
            exit()
        data = response.json()
        for r in data['results']:
            resources[r['url']] = r
        url = data['next']
    print("{} {} resources.".format(len(resources), resource_name, ))
    return resources

### returns:  {"films": [ url:{film} ] }
def fetch_all_from_root(ROOT):
    root = requests.get(ROOT).json()
    all_resources = {}
    for r,u in root.items():
        all_resources[r] = fetch_all_resources_for(r,u)
    return all_resources

### Crude for local dev. Load from picked cache, or scrape the SW API from root.
all_resources = {}
if os.path.isfile("swapi.p"):
    all_resources = pickle.load( open( "swapi.p", "rb" ) )
    print("Unpickled all resources")
else:
    all_resources = fetch_all_from_root(SWAPI_ROOT)
    pickle.dump( all_resources, open( "swapi.p", "wb" ) )
    print("Pickled the resources to be a good API netizen")

### At this point, all_resources should be a dict{"type": {url: {resource}}}

print()
print("Resources (types): {}".format(len(all_resources)))
print("Resources (all): {}".format(sum( len(urls) for urls in all_resources.values() ) ))
print()

client = MongoClient(MONGODB_URI)
DB = client[MONGODB_NAME]

print("Storing resources in database")
for resource_type,resource_collection in all_resources.items():
    db_collection = DB[resource_type]
    db_insert_result = db_collection.insert_many(resource_collection.values())
    db_insert_result_diff = len(resource_collection) - len(db_insert_result.inserted_ids)
    if db_insert_result_diff != 0:
        print("{} {} resources did not save".format(db_insert_result_diff,resource_type))
        exit()

## Everything is now in mongo! Yay!
print()
print ("Successfully stored all data!")
print()

print ("Replacing URL's with Mongo ID's!")

## Lookup table of URI: ID (a shortcut)
url_ids = {}

def url_to_id(url):
    if(url in url_ids.keys()):
        return url_ids[url]

    ## We go diving into the database.
    which_resource_type = list(r for r in all_resources.keys() if r in url)[0]


    ## assume a direct mapping between resource type and collection name
    db_resource = DB[which_resource_type].find_one({"url": url})
    url_ids[url] = db_resource["_id"]
    return db_resource["_id"]

def replace_fk_url_with_id_in_document(d):
    ## traverse document field/values
    for k,v in d.items():
        ## if val is a string AND val is a URI:
        if isinstance(v, str) and "http://" in v and k != "url": # keep the 'url' field for posterity
            ## Get the linked document by its "url" field
            new_id = url_to_id(v)
            ## Swap out the URL for the ID
            d[k] = ObjectId(new_id)

        ## If val is a list:
        if isinstance(v, list):
            new_v = []
            ## for each value in list:
            for i in v:
                ## if val is a string AND val is a URI:
                if isinstance(i, str) and "http://" in i:
                    ## Get the linked document by its "url" field
                    new_id = url_to_id(i)
                    ## Swap out the URL for the ID
                    new_v.append(ObjectId(new_id))
                else:
                    new_v.append(i)
            d[k] = new_v

        ## elif val is a dict:
        elif isinstance(v, dict):
            ## traverse that (sub)document
            d[k] = replace_fk_url_with_id_in_document(v)

        else: #do nothing for other field values/types
            pass
    return d

## For each collection
for c in DB.collection_names():
    ## For each document in collection
    for document in DB[c].find():
        if 'url' not in document.keys():
            print("Found a document without a url...")
            continue
        print("Replacing urls in {}.".format(document['url']))
        document = replace_fk_url_with_id_in_document(document)

        ## This shoudl grow over time to the total # of resources
        print("{} ids in map".format(len(url_ids)))

        DB[c].update({"_id": document["_id"]}, document)
        print("Replaced uri's in {}".format(document["_id"]))
        print()

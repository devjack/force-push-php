<?php

namespace App\Transformers;

use App\Person;
use League\Fractal;


class PeopleTransformer extends Fractal\TransformerAbstract
{

    public function transform(Person $person)
    {
        return [
            "name" => $person->name,
            "height" => $person->height,
            "mass" => $person->mass,
            "hair_color" => $person->hair_color,
            "skin_color" => $person->skin_color,
            "eye_color" => $person->eye_color,
            "birth_year" => $person->birth_year,
            "gender" => $person->gender,
            "homeworld" =>  $person->homeworld,
            "films" => array_map(function($id) {
                return route('films', ['id'=>$id]);
            }, $person->films),
            "species" => [],
            "vehicles" => [],
            "starships" => [],
            "created" => $person->created,
            "edited" => $person->edited,
            "url" => url('people', $person->id)
        ];
    }
}

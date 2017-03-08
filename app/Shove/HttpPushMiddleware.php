<?php

namespace App\Shove;

use Illuminate\Http\Request;

use Illuminate\Contracts\Logging\Log;

class HttpPushMiddleware
{

    /**
     * @param Request $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        // After middleware (add links at end of middleware stack)
        $pushLevel = $request->input("_push") ?? 0;

        $response = $next($request);

        if($pushLevel >= 0) {
            $response->header("Link", $this->generatePushHeader($pushLevel));
        }
        return $response;


    }

    protected function generatePushHeader($pushLevel) : string
    {
        // Push $pushLevel's of resources. Countdown until 0;


        $pushables = app('shove')->getPushables();

        // Trust me - this works. I think.
        if (!empty($pushables)) {
            $links = array_map(function($resource, $mime) use ($pushLevel) {
                $resource = http_build_url($resource, [
                        'query' => '_push='.($pushLevel)
                    ],HTTP_URL_JOIN_QUERY
                );

                $attribs = [];
                $attribs[] = "<".$resource.">";
                if($mime) {
                    $attribs[] = ($mime ? " as=".$mime : "");
                }
                $attribs[] = "rel=preload"; // always be pushing.

                $linkValue = implode("; ", $attribs);

                logger("Pushing: " . $linkValue);
                return $linkValue;
            }, array_keys($pushables), $pushables);

            return implode(',', $links);
        }
        return "";
    }
}
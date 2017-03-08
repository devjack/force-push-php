<?php

if (! function_exists('shove')) {
    /**
     * Push the generated named route
     *
     * @param  string $name
     * @param  string $as
     * @param  mixed $params Further args passed to route() service.
     * @return string
     */
    function shove($name, $parameters = [], $as = "")
    {
        $path = app('url')->route($name, $parameters, false);
        $url = app('url')->route($name, $parameters);
        app('shove')->push($path, $as);
        return $url;
    }
}
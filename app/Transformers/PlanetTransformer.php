<?php

namespace App\Transformers;

use App\Planet;
use League\Fractal;


class PlanetTransformer extends Fractal\TransformerAbstract
{

    public function transform(Planet $planet)
    {
        return [
            "climate" => $planet->climate,
            "created" => $planet->created,
            "diameter" => $planet->diameter,
            "edited" => $planet->edited,
            "films" => array_map(function($id) {
                return route('film', ['id'=>$id]);
            }, $planet->films),
            "gravity" => $planet->gravity,
            "name" => $planet->name,
            "orbital_period" => $planet->orbital_period,
            "population" => $planet->population,
            "residents" => array_map(function($id) {
                return route('people', ['id'=>$id]);
            }, $planet->residents),
            "rotation_period" => $planet->rotation_period,
            "surface_water" => $planet->surface_water,
            "terrain" => $planet->terrain,
            "url" => route('planet', ['id' => $planet->id]),
        ];
    }
}
<?php

namespace App\Transformers;

use App\Starship;
use League\Fractal;


class StarshipTransformer extends Fractal\TransformerAbstract
{

    public function transform(Starship $ship)
    {
        return [

            "MGLT" => $ship->MGLT,
            "cargo_capacity" => $ship->cargo_capacity,
            "consumables" => $ship->consumables,
            "cost_in_credits" => $ship->cost_in_credits,
            "created" => $ship->created,
            "crew" => $ship->crew,
            "edited" => $ship->edited,
            "hyperdrive_rating" => $ship->hyperdrive_rating,
            "length" => $ship->length,
            "manufacturer" => $ship->manufacturer,
            "max_atmosphering_speed" => $ship->max_atmosphering_speed,
            "model" => $ship->model,
            "name" => $ship->name,
            "passengers" => $ship->passengers,
            "films" => array_map(function($id) {
                return route('film', ['id'=>$id]);
            }, $ship->films),
            "pilots" => array_map(function($id) {
                return route('people', ['id'=>$id]);
            }, $ship->pilots),
            "starship_class" => $ship->starship_class,
            "url" => route('starship', ['id'=>$ship->id]),

        ];
    }

}
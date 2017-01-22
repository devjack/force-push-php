<?php

namespace App\Transformers;

use App\Vehicle;
use League\Fractal;


class VehicleTransformer extends Fractal\TransformerAbstract
{

    public function transform(Vehicle $vehicle)
    {
        return [

            "cargo_capacity" => $vehicle->cargo_capacity,
            "consumables" => $vehicle->consumables,
            "cost_in_credits" => $vehicle->cost_in_credits,
            "created" => $vehicle->created,
            "crew" => $vehicle->crew,
            "edited" => $vehicle->edited,
            "length" => $vehicle->length,
            "manufacturer" => $vehicle->manufacturer,
            "max_atmosphering_speed" => $vehicle->max_atmosphering_speed,
            "model" => $vehicle->model,
            "name" => $vehicle->name,
            "passengers" => $vehicle->passengers,
            "pilots" =>array_map(function($id) {
                return route('people', $id);
            }, $vehicle->pilots),
            "films" =>array_map(function($id) {
                return route('film', $id);
            }, $vehicle->films),
            "vehicle_class" => $vehicle->vehicle_class,
            "url" => route('vehicle', $vehicle->id),
        ];
    }

}
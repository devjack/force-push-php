<?php

namespace App\Transformers;

use App\Species;
use League\Fractal;


class SpeciesTransformer extends Fractal\TransformerAbstract
{

    public function transform(Species $species)
    {
        return [
            "average_height" => $species->average_height,
            "average_lifespan" => $species->average_lifespan,
            "classification" => $species->classification,
            "created" => $species->created,
            "designation" => $species->designation,
            "edited" => $species->edited,
            "eye_colors" => $species->eye_colors,
            "hair_colors" => $species->hair_colors,
            "homeworld" => $species->homeworld,
            "language" => $species->language,
            "name" => $species->name,
            "people" => array_map(function($id) {
                return route('people', ['id'=>$id]);
            }, $species->people),
            "films" => array_map(function($id) {
                return route('film', ['id'=>$id]);
            }, $species->films),
            "skin_colors" => $species->skin_colors,
            "url" => route('species', ['id'=>$species->id]),
        ];
    }

}
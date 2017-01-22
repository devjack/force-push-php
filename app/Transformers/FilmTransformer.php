<?php

namespace App\Transformers;

use App\Film;
use League\Fractal;


class FilmTransformer extends Fractal\TransformerAbstract
{

    public function transform(Film $film)
    {
        return [
            "title" => $film->title,
            "episode_id" => (int) $film->episode_id,
            "opening_crawl" => $film->opening_crawl,
            "director" => $film->director,
            "producer" => $film->producer,
            "release_date" => $film->release_date,
            "characters" => array_map(function($id) {
                return route('people', ['id'=>$id]);
            }, $film->characters),
            "planets" => [],
            "starships" => [],
            "vehicles" => [],
            "species" => [],
            "created" => $film->created,
            "edited" => $film->edited,
            "url" => route('film', ['id'=>$film->id])
        ];
    }

}
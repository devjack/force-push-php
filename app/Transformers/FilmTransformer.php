<?php

namespace App\Transformers;

use App\Film;
use App\Transformers\Behaviour\TransformWithSummaryTrait;
use League\Fractal;


class FilmTransformer extends Fractal\TransformerAbstract
{
    //use TransformWithSummaryTrait;

    protected $shortFields = [
        'id',
        'title',
        'url',
    ];

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
                return shove('people', ['id'=>$id]);
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
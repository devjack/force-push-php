<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Fractal\Fractal;
use App\Http\Controllers\Controller;

use App\Transformers\StarshipTransformer;
use App\Starship;

class StarshipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $films = Starship::get();

        return Fractal::create($films, new StarshipTransformer())
            ->respond(function(JsonResponse $response) {
                $response
                    ->setStatusCode(200)
                    ->withHeaders([
                        // todo: push stuff here.
                    ]);
            });
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $films = Starship::find($id);

        return Fractal::create($films, new StarshipTransformer())
            ->respond(function(JsonResponse $response) {
                $response
                    ->setStatusCode(200)
                    ->withHeaders([
                        // todo: push stuff here.
                    ]);
            });
    }
}

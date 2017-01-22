<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Fractal\Fractal;
use App\Http\Controllers\Controller;

use App\Transformers\SpeciesTransformer;
use App\Species;

class SpeciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $films = Species::get();

        return Fractal::create($films, new SpeciesTransformer())
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
        $films = Species::find($id);

        return Fractal::create($films, new SpeciesTransformer())
            ->respond(function(JsonResponse $response) {
                $response
                    ->setStatusCode(200)
                    ->withHeaders([
                        // todo: push stuff here.
                    ]);
            });
    }
}
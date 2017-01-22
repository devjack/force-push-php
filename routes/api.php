<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get("/films", "Api\\FilmsController@index")->name('film_index');
Route::get("/films/{id}", "Api\\FilmsController@show")->name("film");

Route::get("/species", "Api\\SpeciesController@index")->name("species_index");
Route::get("/species/{id}", "Api\\SpeciesController@show")->name("species");

Route::get("/planets", "Api\\PlanetsController@index")->name("planet_index");
Route::get("/planets/{id}", "Api\\PlanetsController@show")->name("planet");

Route::get("/vehicles", "Api\\VehiclesController@index")->name("vehicle_index");
Route::get("/vehicles/{id}", "Api\\VehiclesController@show")->name("vehicle");

Route::get("/starships", "Api\\StarshipsController@index")->name("starship_index");
Route::get("/starships/{id}", "Api\\StarshipsController@show")->name("starship");

Route::get("/people", "Api\\PeopleController@index")->name("people_index");
Route::get("/people/{id}", "Api\\PeopleController@show")->name("people");



Route::get('/', function (Request $request) {
    return [
        route('film_index'),
        route('species_index'),
        route('planet_index'),
        route('starship_index'),
        route('vehicle_index'),
        route('people_index'),
    ];
});


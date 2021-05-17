<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\SearchController::class, 'index'])->name('index');

Route::get('/nomera', [\App\Http\Controllers\PagesController::class, 'numbers'])
    ->name('numbers');
Route::get('/nomer/{slug}', [\App\Http\Controllers\PagesController::class, 'number'])
    ->name('number');

Route::get('/robots.txt', [\App\Http\Controllers\SeoController::class, 'robots']);
Route::get('/sitemap.xml', [\App\Http\Controllers\SeoController::class, 'sitemap']);

Route::get('/test', function() {
    $regCars = \App\Models\Car::take(10)
        ->with('color', 'fuel', 'body', 'manufacturer', 'model', 'type', 'purpose')
        ->get();

    // foreach($regCars as $regCar) {
    //     dd($regCar->color);
    // }

    $client = \Elasticsearch\ClientBuilder::create()->build();
    $params = [
        'index' => 'my_index',
        'id'    => 'my_id',
        'body'  => [
            'testField' => 'abc1'
        ]
    ];
    
    $response = $client->index($params);
    
    $params = [
        'index' => 'my_index',
        'body'  => [
            'query' => [
                'fuzzy' => [
                    'testField' => 'abc'
                ]
            ],
            // 'fuzziness'=>'AUTO'
        ]
    ];
    
    $response = $client->search($params);
    dd($response);
    // print_r($response);

    // dd($regCars);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

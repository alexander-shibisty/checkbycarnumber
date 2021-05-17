<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Arr;

class PagesController extends Controller
{

    const PAGE_LIMIT = 50;

    public function numbers(Request $request) {
        $data = $request->all();
        $cars = Car::take(self::PAGE_LIMIT)
            ->with('color', 'fuel', 'body', 'manufacturer', 'model', 'type', 'purpose')
            // ->orderBy('id', 'DESC')
        ;

        $q = trim(Arr::get($data, 'q'));
        if($q) {
            $cars = $cars->where('number', $q);
        }

        $cars = $cars->paginate(self::PAGE_LIMIT);

        $page = $request->input('page') ?? 1;
        $limit = self::PAGE_LIMIT;

        return view('pages.numbers', compact('cars', 'page', 'limit'));
    }

    public function number(Request $request) {
        $slug = $request->slug;
        $car = Car::where('slug', $slug)
            ->with('color', 'fuel', 'body', 'manufacturer', 'model', 'type', 'purpose')
            ->first();
        $fields = Car::$fields;
        // dd($car);
        return view('pages.number', compact('car', 'fields'));
    }
}

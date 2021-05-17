<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Manufacturer;
use Cache;
use View;

class SearchController extends Controller
{
    public function index(Request $request) {
        View::share('unique_class', 'home');
        // $allOperations = \DB::connection('mongodb')
        //     ->collection('reg_cars')
        //     ->count();
        // dd($allOperations);

        $manufacturers = Manufacturer::select()->orderBy('name', 'ASC')->get();        

        return view('index', compact('manufacturers'));
    }
}

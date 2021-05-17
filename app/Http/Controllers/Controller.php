<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Cache;
use View;
use Route;
use App\Models\Color;
use App\Models\Body;
use App\Models\Fuel;
use App\Models\Purpose;
use App\Models\Type;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const CACHE_TIME = 60 * 10;

    public function __construct() {
        $this->loadRegColor();
        $this->loadRegBody();
        $this->loadRegFuel();
        $this->loadRegType();
        $this->loadRegPurpose();
        $this->loadRouteName();
    }

    public function loadRegColor() {
        $colors = Cache::remember('colors', self::CACHE_TIME, function () {
            return Color::get();
        });

        View::share('colors', $colors);
    }

    public function loadRegBody() {
        $bodies = Cache::remember('bodies', self::CACHE_TIME, function () {
            return Body::get();
        });

        View::share('bodies', $bodies);
    }

    public function loadRegFuel() {
        $fuels = Cache::remember('fuels', self::CACHE_TIME, function () {
            return Fuel::get();
        });

        View::share('fuels', $fuels);
    }

    public function loadRegType() {
        $types = Cache::remember('types', self::CACHE_TIME, function () {
            return Type::get();
        });

        View::share('types', $types);
    }

    public function loadRegPurpose() {
        $purposes = Cache::remember('purposes', self::CACHE_TIME, function () {
            return Purpose::get();
        });

        View::share('purposes', $purposes);
    }

    public function loadRouteName() {
        View::share('routeName', Route::currentRouteName());
    }
}

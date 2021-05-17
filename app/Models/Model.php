<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Base;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Model extends Base
{
    use HasFactory, HybridRelations;

    protected $connection = 'mysql';
    public $table = 'reg_car_models';

}
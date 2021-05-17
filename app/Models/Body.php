<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Body extends Model
{
    use HasFactory, HybridRelations;

    protected $connection = 'mysql';
    public $table = 'reg_car_bodies';

}

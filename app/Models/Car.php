<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as BaseModel;

class Car extends BaseModel
{
    protected $connection = 'mongodb';
    protected $primaryKey = 'id';
    protected $collection = 'reg_cars';

    public static $fields = [
        "person" => "Регистрируемый",
        "number" => "Номер",
        "weight" => "Полный вес",
        "own_weight" => "Вес",
        "capacity" => "Объем",
        "year" => "Год выпуска",
        "operation_date" => "Дата операции",
        "operation_code" => "Код операции",
        "departament_code" => "Регистратор",
        "koatuu" => "Объект",
        "manufacturer" => "Производитель",
        "model" => "Модель",
        "body" => "Кузов",
        "type" => "Тип",
        "color" => "Цвет",
        "fuel" => "Топливо",
        "purpose" => "Назначение",
    ];

    public function color() {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }

    public function fuel() {
        return $this->hasOne(Fuel::class, 'id', 'fuel_id');
    }

    public function body() {
        return $this->hasOne(Body::class, 'id', 'body_id');
    }

    public function manufacturer() {
        return $this->hasOne(Manufacturer::class, 'id', 'manufacturer_id');
    }

    public function model() {
        return $this->hasOne(Model::class, 'id', 'model_id');
    }

    public function type() {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }

    public function purpose() {
        return $this->hasOne(Purpose::class, 'id', 'purpose_id');
    }
}

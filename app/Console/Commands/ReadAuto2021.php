<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Arr;
use App\Models\Car;

use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Body;
use App\Models\Type;
use App\Models\Fuel;
use App\Models\Purpose;
use App\Models\Color;

class ReadAuto2021 extends Command
{
    const YEAR = 2021;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:2021 {file_path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->manufacturers = $this->takeNameFrofCollection(Manufacturer::get());
        $this->models = $this->takeNameFrofCollection(Model::get());
        $this->bodies = $this->takeNameFrofCollection(Body::get());
        $this->types = $this->takeNameFrofCollection(Type::get());
        $this->fuels = $this->takeNameFrofCollection(Fuel::get());
        $this->purposes = $this->takeNameFrofCollection(Purpose::get());
        $this->colors = $this->takeNameFrofCollection(Color::get());
    }

    public function takeNameFrofCollection($collection) {
        $result = [];

        foreach($collection as $item) {
            $result[$item->name] = $item->id;
        }

        return $result;
    }

    public function getIdByName(&$collection, $name, $className = null) {
        if(isset($collection[$name])) {
            return $collection[$name];
        }

        $getId = $this->createItemByName($className ? $className : get_class($item), $name);
        $collection[$name] = $getId;

        return $getId;
    }

    public function createItemByName($className, $name) {
        $obj = new $className;

        return $obj->insertGetId([
            'name' => $name,
            'slug' => \Str::slug($name, '-'),
        ]);
    }

    public function prepareStr($str) {
        return str_replace(['"'], [''], $str);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \DB::connection('mongodb')
            ->collection('reg_cars')
            ->where([
                'registration_year' => self::YEAR,
            ])
            ->delete();

        $filePath = base_path($this->argument('file_path'));

        $index = 0;
        $cellNames = null;
        $cars = [];
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                $row = Arr::get($data, 0);
                    
                if($index === 0) {
                    $cellNames = explode(';', $row);
                } else {
                    $cells = explode(';', $row);
                    $car = [];
    
                    foreach($cellNames as $key => $value) {
                        $car[$value] = str_replace('"', '', $cells[$key]);
                    } unset($key, $value);

                    if($car['"N_REG_NEW"'] !== 'NULL') {
                        $cars[] = [
                            'slug' => \Str::slug($car['"N_REG_NEW"'], '-'),

                            'person' => $car['PERSON'],
                            'number' => $car['"N_REG_NEW"'],
                            'weight' => $car['"TOTAL_WEIGHT"'],
                            'own_weight' => $car['"OWN_WEIGHT"'],
                            'capacity' => $car['"CAPACITY"'],
                            'year' => $car['"MAKE_YEAR"'],
                            'operation_date' => strtotime($car['"D_REG"']),
                            'operation_code' => $car['"OPER_CODE"'],
                            'departament_code' => $car['"DEP_CODE"'],
                            'koatuu' => $car['"REG_ADDR_KOATUU"'],
                            'registration_year' => self::YEAR,
                            'created_at' => time(),

                            'manufacturer_id' => $this->getIdByName(
                                $this->manufacturers,
                                $this->prepareStr(str_replace($car['"MODEL"'], '', $car['"BRAND"'])),
                                Manufacturer::class
                            ),
                            'model_id' => $this->getIdByName($this->models, $this->prepareStr($car['"MODEL"']), Model::class),
                            'body_id' => $this->getIdByName($this->bodies, $this->prepareStr($car['"BODY"']), Body::class),
                            'type_id' => $this->getIdByName($this->types, $this->prepareStr($car['"KIND"']), Type::class),
                            'color_id' => $this->getIdByName($this->colors, $this->prepareStr($car['"COLOR"']), Color::class),
                            'fuel_id' => $this->getIdByName($this->fuels, $this->prepareStr($car['"FUEL"']), Fuel::class),
                            'purpose_id' => $this->getIdByName($this->purposes, $this->prepareStr($car['"PURPOSE"']), Purpose::class),
                        ];
                    }

                    unset($car, $cells);
                }

                $index++;
            } unset($data);
            
            fclose($handle);
        }

        \DB::connection('mongodb')
            ->collection('reg_cars')
            ->insert($cars);

        return 0;
    }
}

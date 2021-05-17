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

class ReadAuto2017 extends Command
{
    const YEAR = 2017;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:2017 {file_path}';

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

                    if($car['n_reg_new'] !== 'NULL') {
                        $cars[] = [
                            'slug' => \Str::slug($car['n_reg_new'], '-'),

                            'person' => $car['person'],
                            'number' => $car['n_reg_new'],
                            'weight' => $car['total_weight'],
                            'own_weight' => $car['own_weight'],
                            'capacity' => $car['capacity'],
                            'year' => $car['make_year'],
                            'operation_date' => strtotime($car['d_reg']),
                            'operation_code' => $car['oper_code'],
                            'departament_code' => $car['dep_code'],
                            'koatuu' => $car['reg_addr_koatuu'],
                            'registration_year' => self::YEAR,
                            'created_at' => time(),

                            'manufacturer_id' => $this->getIdByName(
                                $this->manufacturers,
                                $this->prepareStr(str_replace($car['model'], '', $car['brand'])),
                                Manufacturer::class
                            ),
                            'model_id' => $this->getIdByName($this->models, $this->prepareStr($car['model']), Model::class),
                            'body_id' => $this->getIdByName($this->bodies, $this->prepareStr($car['body']), Body::class),
                            'type_id' => $this->getIdByName($this->types, $this->prepareStr($car['kind']), Type::class),
                            'color_id' => $this->getIdByName($this->colors, $this->prepareStr($car['color']), Color::class),
                            'fuel_id' => $this->getIdByName($this->fuels, $this->prepareStr($car['fuel']), Fuel::class),
                            'purpose_id' => $this->getIdByName($this->purposes, $this->prepareStr($car['purpose']), Purpose::class),
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

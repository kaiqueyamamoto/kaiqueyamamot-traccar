<?php

use Illuminate\Database\Seeder;
use Tobuli\Entities\DeviceFuelMeasurement;

class FuelMeasurementsTableSeeder extends Seeder
{
    public function run()
    {
        DeviceFuelMeasurement::updateOrCreate(['title' => 'l/100km'], [
            'title' => 'l/100km',
            'fuel_title' => 'liter',
            'distance_title' => 'Kilometers'
        ]);

        DeviceFuelMeasurement::updateOrCreate(['title' => 'MPG'], [
            'title' => 'MPG',
            'fuel_title' => 'gallon',
            'distance_title' => 'Miles'
        ]);

        DeviceFuelMeasurement::updateOrCreate(['title' => 'kW/km'], [
            'title' => 'kW/km',
            'fuel_title' => 'kilowatt-hour',
            'distance_title' => 'Kilometers'
        ]);
    }

}
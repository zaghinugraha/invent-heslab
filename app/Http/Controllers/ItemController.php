<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function show($id)
    {
        // For now, use dummy data. Replace with actual database query later.
        $item = [
            'id' => $id,
            'name' => 'Sensor ' . $id,
            'price' => 'Rp. 13,000',
            'image' => 'https://digiwarestore.com/11109-large_default/dht11-module-temperature-humidity-sensor-temperatur-kelembaban-for-arduino-with-led-297030.jpg',
            'description' => 'Description for Sensor ' . $id,
        ];

        return view('item-detail', compact('item'));
    }
}

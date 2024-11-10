<?php

namespace Database\Seeders;

use App\Models\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = collect([
            [
                'name' => 'ESP32',
                'slug' => 'esp32',
                'code' => 1,
                'quantity' => 10,
                'quantity_alert' => 10,
                'price' =>200000,
                'notes' => 'ini adalah esp32 skibidi',
                'specification' =>'<ul>
                                    <li> ram 8gb </li>
                                    <li> rtx 4090 </li>
                                    <li> etcc </li>
                                   </ul>',
                'category_id' => 1,
                'user_id'=>1,
//                'uuid'=>Str::uuid()
            ],
            [
                'name' => 'light sensor',
                'slug' => 'lightsensor',
                'code' => 2,
                'quantity' => 10,
                'quantity_alert' => 10,
                'price' =>5000,
                'notes' => null,
                'category_id' => 2,
                'user_id'=>1,
//                'uuid'=>Str::uuid()
            ],
            [
                'name' => 'temp sensor',
                'slug' => 'tempsensor',
                'code' => 3,
                'quantity' => 10,
                'quantity_alert' => 10,
                'price' =>8000,
                'notes' => 'ini adalah temp sensor untuk memeriksa suhu dalam skala Rizz',
                'category_id' => 2,
                'user_id'=>1,
//                'uuid'=>Str::uuid()
            ],
            [
                'name' => 'Arduino Uno R3',
                'slug' => 'uno_r3',
                'code' => 4,
                'quantity' => 10,
                'quantity_alert' => 10,
                'price' =>300000,
                'notes' => 'ini adalah arduino uno r3 mewing edition',
                'category_id' => 1,
                'user_id'=>1,
//                'uuid'=>Str::uuid()
            ],
            [
                'name' => 'Kabel',
                'slug' => 'kabel_1',
                'code' => 5,
                'quantity' => 10,
                'quantity_alert' => 10,
                'price' =>500,
                'notes' => 'ini adalah kabel terskibidi yang pernah ada',
                'category_id' => 4,
                'user_id'=>1,
//                'uuid'=>Str::uuid()
            ],
            [
                'name' => 'Raspberry Pi 4',
                'slug' => 'raspberry-pi-4',
                'code' => 6,
                'quantity' => 15,
                'quantity_alert' => 5,
                'price' => 700000,
                'notes' => 'Mini komputer berperforma tinggi untuk IoT',
                'category_id' => 1,
                'user_id'=>1,
            ],
            [
                'name' => 'Gyroscope Sensor',
                'slug' => 'gyroscope-sensor',
                'code' => 7,
                'quantity' => 20,
                'quantity_alert' => 5,
                'price' => 15000,
                'notes' => 'Sensor untuk mendeteksi rotasi',
                'category_id' => 2,
                'user_id'=>1,
            ],
            [
                'name' => 'Ultrasonic Sensor',
                'slug' => 'ultrasonic-sensor',
                'code' => 8,
                'quantity' => 12,
                'quantity_alert' => 3,
                'price' => 12000,
                'notes' => 'Sensor untuk mendeteksi jarak dengan gelombang suara',
                'category_id' => 2,
                'user_id'=>1,
            ],
            [
                'name' => 'Jumper Wires',
                'slug' => 'jumper-wires',
                'code' => 9,
                'quantity' => 100,
                'quantity_alert' => 20,
                'price' => 100,
                'notes' => 'Kabel jumper untuk koneksi antar komponen',
                'category_id' => 4,
                'user_id'=>1,
            ],
            [
                'name' => 'NodeMCU ESP8266',
                'slug' => 'nodemcu-esp8266',
                'code' => 10,
                'quantity' => 10,
                'quantity_alert' => 5,
                'price' => 150000,
                'notes' => 'Board dengan modul Wi-Fi untuk IoT',
                'category_id' => 1,
                'user_id'=>1,
            ],
            [
                'name' => 'Humidity Sensor',
                'slug' => 'humidity-sensor',
                'code' => 11,
                'quantity' => 15,
                'quantity_alert' => 5,
                'price' => 8000,
                'notes' => 'Sensor untuk mengukur tingkat kelembapan udara',
                'category_id' => 2,
                'user_id'=>1,
            ],
            [
                'name' => 'Breadboard',
                'slug' => 'breadboard',
                'code' => 12,
                'quantity' => 25,
                'quantity_alert' => 10,
                'price' => 20000,
                'notes' => 'Papan untuk prototipe rangkaian elektronik',
                'category_id' => 3,
                'user_id'=>1,
            ],
            [
                'name' => 'Micro USB Cable',
                'slug' => 'micro-usb-cable',
                'code' => 13,
                'quantity' => 30,
                'quantity_alert' => 10,
                'price' => 5000,
                'notes' => 'Kabel Micro USB untuk pengisian dan koneksi data',
                'category_id' => 4,
                'user_id'=>1,
            ],
            [
                'name' => 'DHT11 Temperature and Humidity Sensor',
                'slug' => 'dht11-sensor',
                'code' => 14,
                'quantity' => 20,
                'quantity_alert' => 5,
                'price' => 10000,
                'notes' => 'Sensor suhu dan kelembapan kombinasi',
                'category_id' => 2,
                'user_id'=>1,
            ],
            [
                'name' => 'Ethernet Shield for Arduino',
                'slug' => 'ethernet-shield',
                'code' => 15,
                'quantity' => 8,
                'quantity_alert' => 3,
                'price' => 150000,
                'notes' => 'Ethernet shield untuk menghubungkan Arduino ke internet',
                'category_id' => 1,
                'user_id'=>1,
            ],
            [
                'name' => 'MQ-2 Gas Sensor',
                'slug' => 'mq-2-gas-sensor',
                'code' => 16,
                'quantity' => 10,
                'quantity_alert' => 3,
                'price' => 20000,
                'notes' => 'Sensor untuk mendeteksi gas berbahaya',
                'category_id' => 2,
                'user_id'=>1,
            ],
            [
                'name' => 'DC Motor',
                'slug' => 'dc-motor',
                'code' => 17,
                'quantity' => 5,
                'quantity_alert' => 2,
                'price' => 30000,
                'notes' => 'Motor DC untuk proyek elektronik',
                'category_id' => 3,
                'user_id'=>1,
            ],
            [
                'name' => 'USB to Serial Adapter',
                'slug' => 'usb-serial-adapter',
                'code' => 18,
                'quantity' => 15,
                'quantity_alert' => 5,
                'price' => 40000,
                'notes' => 'Adaptor untuk komunikasi serial USB',
                'category_id' => 3,
                'user_id'=>1,
            ],
            [
                'name' => 'LDR (Light Dependent Resistor)',
                'slug' => 'ldr-sensor',
                'code' => 19,
                'quantity' => 20,
                'quantity_alert' => 5,
                'price' => 7000,
                'notes' => 'Sensor yang sensitif terhadap cahaya',
                'category_id' => 2,
                'user_id'=>1,
            ],
            [
                'name' => 'Relay Module 5V',
                'slug' => 'relay-module-5v',
                'code' => 20,
                'quantity' => 10,
                'quantity_alert' => 3,
                'price' => 12000,
                'notes' => 'Modul relay 5V untuk kontrol perangkat',
                'category_id' => 3,
                'user_id'=>1,
            ],
            [
                'name' => 'Jumper Cables',
                'slug' => 'jumper-cables',
                'code' => 021,
                'quantity' => 100,
                'quantity_alert' => 20,
                'price' => 150,
                'notes' => 'Kabel jumper untuk rangkaian elektronik',
                'category_id' => 4,
                'user_id'=>1,
            ],
            [
                'name' => 'Bluetooth Module HC-05',
                'slug' => 'bluetooth-hc-05',
                'code' => 022,
                'quantity' => 5,
                'quantity_alert' => 2,
                'price' => 75000,
                'notes' => 'Modul bluetooth untuk komunikasi wireless',
                'category_id' => 1,
                'user_id'=>1,
            ],
            [
                'name' => 'Software IDE for Arduino',
                'slug' => 'arduino-ide',
                'code' => 023,
                'quantity' => 50,
                'quantity_alert' => 10,
                'price' => 0,
                'notes' => 'Software IDE untuk pemrograman Arduino',
                'category_id' => 5,
                'user_id'=>1,
            ],
            [
                'name' => 'USB Cable for Arduino',
                'slug' => 'usb-cable-arduino',
                'code' => 024,
                'quantity' => 30,
                'quantity_alert' => 5,
                'price' => 10000,
                'notes' => 'Kabel USB untuk menghubungkan Arduino ke komputer',
                'category_id' => 4,
                'user_id'=>1,
            ],
            [
                'name' => 'FTDI Module',
                'slug' => 'ftdi-module',
                'code' => 025,
                'quantity' => 10,
                'quantity_alert' => 3,
                'price' => 50000,
                'notes' => 'Modul untuk komunikasi serial dengan FTDI chip',
                'category_id' => 3,
                'user_id'=>1,
            ]

        ]);

        $products->each(function ($product){
            Product::create($product);
        });
    }
}

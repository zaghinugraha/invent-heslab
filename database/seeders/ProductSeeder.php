<?php

namespace Database\Seeders;

use App\Models\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
                'price' => 200000,
                'notes' => 'The ESP32 is a series of low-cost, low-power system on a chip microcontrollers with integrated Wi-Fi and dual-mode Bluetooth.',
                'specification' => '<li>Microcontroller: Tensilica Xtensa LX6</li><li>Clock Speed: 240 MHz</li>',
                'category_id' => 1,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Light Sensor',
                'slug' => 'light-sensor',
                'code' => 2,
                'quantity' => 10,
                'quantity_alert' => 10,
                'price' => 5000,
                'notes' => 'A light sensor is a device that detects light and converts it into an electrical signal.',
                'specification' => '<li>Type: Photodiode</li><li>Wavelength: 400-700 nm</li>',
                'category_id' => 2,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Temperature Sensor',
                'slug' => 'temperature-sensor',
                'code' => 3,
                'quantity' => 10,
                'quantity_alert' => 10,
                'price' => 8000,
                'notes' => 'A temperature sensor is a device that measures temperature through an electrical signal.',
                'specification' => '<li>Type: Thermistor</li><li>Range: -55°C to 125°C</li>',
                'category_id' => 2,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Arduino Uno R3',
                'slug' => 'uno-r3',
                'code' => 4,
                'quantity' => 10,
                'quantity_alert' => 10,
                'price' => 300000,
                'notes' => 'The Arduino Uno R3 is a microcontroller board based on the ATmega328P.',
                'specification' => '<li>Microcontroller: ATmega328P</li><li>Clock Speed: 16 MHz</li>',
                'category_id' => 1,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Cable',
                'slug' => 'cable',
                'code' => 5,
                'quantity' => 10,
                'quantity_alert' => 10,
                'price' => 500,
                'notes' => 'A cable is used to connect electronic components.',
                'specification' => '<li>Length: 1 meter</li><li>Type: Copper</li>',
                'category_id' => 4,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Raspberry Pi 4',
                'slug' => 'raspberry-pi-4',
                'code' => 6,
                'quantity' => 15,
                'quantity_alert' => 5,
                'price' => 700000,
                'notes' => 'The Raspberry Pi 4 Model B is a high-performance mini computer for IoT.',
                'specification' => '<li>Processor: Broadcom BCM2711, quad-core Cortex-A72 (ARM v8) 64-bit SoC @ 1.5GHz</li><li>Power: 5V DC via USB-C connector (minimum 3A)</li>',
                'category_id' => 1,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Gyroscope Sensor',
                'slug' => 'gyroscope-sensor',
                'code' => 7,
                'quantity' => 20,
                'quantity_alert' => 5,
                'price' => 15000,
                'notes' => 'A gyroscope sensor is used to detect rotation.',
                'specification' => '<li>Type: MEMS</li><li>Range: ±250°/s</li>',
                'category_id' => 2,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Ultrasonic Sensor',
                'slug' => 'ultrasonic-sensor',
                'code' => 8,
                'quantity' => 12,
                'quantity_alert' => 3,
                'price' => 12000,
                'notes' => 'An ultrasonic sensor uses sound waves to measure distance.',
                'specification' => '<li>Operating Voltage: 5V</li><li>Min Range: 2cm</li>',
                'category_id' => 2,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Jumper Wires',
                'slug' => 'jumper-wires',
                'code' => 9,
                'quantity' => 100,
                'quantity_alert' => 20,
                'price' => 100,
                'notes' => 'Jumper wires are used for connecting components on a breadboard.',
                'specification' => '<li>Length: 20 cm</li><li>Connector Type: Dupont</li>',
                'category_id' => 4,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'NodeMCU ESP8266',
                'slug' => 'nodemcu-esp8266',
                'code' => 10,
                'quantity' => 10,
                'quantity_alert' => 5,
                'price' => 150000,
                'notes' => 'The NodeMCU ESP8266 is a board with a Wi-Fi module for IoT projects.',
                'specification' => '<li>Microcontroller: ESP8266</li><li>Wi-Fi: 802.11 b/g/n</li>',
                'category_id' => 1,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Humidity Sensor',
                'slug' => 'humidity-sensor',
                'code' => 11,
                'quantity' => 15,
                'quantity_alert' => 5,
                'price' => 8000,
                'notes' => 'A humidity sensor measures the moisture level in the air.',
                'specification' => '<li>Range: 20%-95%</li><li>Accuracy: ±5%</li>',
                'category_id' => 2,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Breadboard',
                'slug' => 'breadboard',
                'code' => 12,
                'quantity' => 25,
                'quantity_alert' => 10,
                'price' => 20000,
                'notes' => 'A breadboard is used for prototyping electronic circuits.',
                'specification' => '<li>Material: ABS Plastic</li><li>Distribution Strip: 200 tie points</li>',
                'category_id' => 3,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Micro USB Cable',
                'slug' => 'micro-usb-cable',
                'code' => 13,
                'quantity' => 30,
                'quantity_alert' => 10,
                'price' => 5000,
                'notes' => 'A Micro USB cable is used for charging and data transfer.',
                'specification' => '<li>Length: 1 meter</li><li>Connector: Micro USB</li>',
                'category_id' => 4,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'DHT11 Temperature and Humidity Sensor',
                'slug' => 'dht11-sensor',
                'code' => 14,
                'quantity' => 20,
                'quantity_alert' => 5,
                'price' => 10000,
                'notes' => 'The DHT11 is a sensor that measures both temperature and humidity.',
                'specification' => '<li>Temperature Range: 0-50°C</li><li>Humidity Range: 20%-90%</li>',
                'category_id' => 2,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Ethernet Shield for Arduino',
                'slug' => 'ethernet-shield',
                'code' => 15,
                'quantity' => 8,
                'quantity_alert' => 3,
                'price' => 150000,
                'notes' => 'An Ethernet shield allows an Arduino to connect to the internet.',
                'specification' => '<li>Controller: W5100</li><li>Speed: 10/100Mb</li>',
                'category_id' => 1,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'MQ-2 Gas Sensor',
                'slug' => 'mq-2-gas-sensor',
                'code' => 16,
                'quantity' => 10,
                'quantity_alert' => 3,
                'price' => 20000,
                'notes' => 'The MQ-2 gas sensor detects hazardous gases.',
                'specification' => '<li>Detection Range: 300-10000 ppm</li><li>Voltage: 5V</li>',
                'category_id' => 2,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'DC Motor',
                'slug' => 'dc-motor',
                'code' => 17,
                'quantity' => 5,
                'quantity_alert' => 2,
                'price' => 30000,
                'notes' => 'A DC motor is used in various electronic projects.',
                'specification' => '<li>Voltage: 6-12V</li><li>Speed: 3000 RPM</li>',
                'category_id' => 3,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'USB to Serial Adapter',
                'slug' => 'usb-serial-adapter',
                'code' => 18,
                'quantity' => 15,
                'quantity_alert' => 5,
                'price' => 40000,
                'notes' => 'A USB to serial adapter is used for serial communication.',
                'specification' => '<li>Chipset: FT232RL</li><li>Baud Rate: 300-921600 bps</li>',
                'category_id' => 3,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'LDR (Light Dependent Resistor)',
                'slug' => 'ldr-sensor',
                'code' => 19,
                'quantity' => 20,
                'quantity_alert' => 5,
                'price' => 7000,
                'notes' => 'An LDR is a sensor that is sensitive to light.',
                'specification' => '<li>Resistance: 10-20kΩ (in light)</li><li>Resistance: 1MΩ (in dark)</li>',
                'category_id' => 2,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Relay Module 5V',
                'slug' => 'relay-module-5v',
                'code' => 20,
                'quantity' => 10,
                'quantity_alert' => 3,
                'price' => 12000,
                'notes' => 'A 5V relay module is used to control devices.',
                'specification' => '<li>Voltage: 5V</li><li>Current: 10A</li>',
                'category_id' => 3,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Jumper Cables',
                'slug' => 'jumper-cables',
                'code' => 21,
                'quantity' => 100,
                'quantity_alert' => 20,
                'price' => 150,
                'notes' => 'Jumper cables are used for connecting electronic components.',
                'specification' => '<li>Length: 20 cm</li><li>Connector Type: Dupont</li>',
                'category_id' => 4,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Bluetooth Module HC-05',
                'slug' => 'bluetooth-hc-05',
                'code' => 22,
                'quantity' => 5,
                'quantity_alert' => 2,
                'price' => 75000,
                'notes' => 'The HC-05 is a Bluetooth module for wireless communication.',
                'specification' => '<li>Bluetooth Protocol: Bluetooth 2.0+EDR</li><li>Range: 10 meters</li>',
                'category_id' => 1,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'Software IDE for Arduino',
                'slug' => 'arduino-ide',
                'code' => 23,
                'quantity' => 50,
                'quantity_alert' => 10,
                'price' => 0,
                'notes' => 'The Arduino IDE is software for programming Arduino boards.',
                'specification' => '<li>Platform: Windows, Mac, Linux</li><li>Language: C/C++</li>',
                'category_id' => 5,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'USB Cable for Arduino',
                'slug' => 'usb-cable-arduino',
                'code' => 24,
                'quantity' => 30,
                'quantity_alert' => 5,
                'price' => 10000,
                'notes' => 'A USB cable for connecting Arduino to a computer.',
                'specification' => '<li>Length: 1 meter</li><li>Connector: USB Type A to B</li>',
                'category_id' => 4,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ],
            [
                'name' => 'FTDI Module',
                'slug' => 'ftdi-module',
                'code' => 25,
                'quantity' => 10,
                'quantity_alert' => 3,
                'price' => 50000,
                'notes' => 'An FTDI module is used for serial communication with FTDI chips.',
                'specification' => '<li>Chipset: FT232RL</li><li>Baud Rate: 300-921600 bps</li>',
                'category_id' => 3,
                'user_id' => 1,
                'uuid' => Str::uuid(),
                'source' => collect(['private', 'university', 'company'])->random(),
            ]
        ]);

        $products->each(function ($product) {
            Product::create($product);
        });
    }
}
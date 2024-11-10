<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    private $items = [
        [
            'id' => 1,
            'name' => 'Sensor DHT11',
            'brand' => 'DF Robot',
            'price' => 11000,
            'stock' => 11,
            'image' => 'https://digiwarestore.com/11109-large_default/dht11-module-temperature-humidity-sensor-temperatur-kelembaban-for-arduino-with-led-297030.jpg',
            'source' => 'Pak Faris',
            'date_arrived' => '1995-10-18',
            'last_maintained' => '1995-12-20',
            'description' => '<p>The DHT11 is a basic, ultra low-cost digital temperature and humidity sensor. It uses a capacitive humidity sensor and a thermistor to measure the surrounding air, and spits out a digital signal on the data pin (no analog input pins needed).</p>',
            'specification' => '<li>Humidity measuring range: 20%-95% (0 degrees -> 50 degrees) Humidity measurement error: +/-5%</li>
                                <li>Temperature measurement range: 0 degrees -> 50 degrees temperature measurement error: +/- 2 degrees</li>
                                <li>Operating voltage 3.3V-5V</li>
                                <li>Output Type Digital Output</li>
                                <li>With fixed bolt hole for easy installation</li>
                                <li>Small plates PCB size: 3.2cm x 1.4cm</li>',
        ],
        [
            'id' => 2,
            'name' => 'Arduino Uno',
            'brand' => 'Arduino',
            'price' => 250000,
            'stock' => 5,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSDm6oJA2PubavnyB9OF1IVAef6QAFQ1PTWhA&s',
            'source' => 'Pak Budi',
            'date_arrived' => '2020-01-15',
            'last_maintained' => '2021-01-15',
            'description' => '<p>The Arduino Uno is a microcontroller board based on the ATmega328P. It has 14 digital input/output pins, 6 analog inputs, a 16 MHz quartz crystal, a USB connection, a power jack, an ICSP header and a reset button.</p>',
            'specification' => '<li>Microcontroller: ATmega328P</li>
                                <li>Operating Voltage: 5V</li>
                                <li>Input Voltage: 7-12V</li>
                                <li>Input Voltage (limit): 6-20V</li>
                                <li>Digital I/O Pins: 14 (6 provide PWM output)</li>
                                <li>Analog Input Pins: 6</li>
                                <li>DC Current per I/O Pin: 20 mA</li>
                                <li>DC Current for 3.3V Pin: 50 mA</li>
                                <li>Flash Memory: 32 KB (ATmega328P) of which 0.5 KB used by bootloader</li>
                                <li>SRAM: 2 KB (ATmega328P)</li>
                                <li>EEPROM: 1 KB (ATmega328P)</li>
                                <li>Clock Speed: 16 MHz</li>',
        ],
        [
            'id' => 3,
            'name' => 'Raspberry Pi 4',
            'brand' => 'Raspberry Pi',
            'price' => 750000,
            'stock' => 3,
            'image' => 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/102/MTA-164389205/no-brand_raspberry-pi-4-model-b_full01.jpg',
            'source' => 'Pak Andi',
            'date_arrived' => '2021-05-10',
            'last_maintained' => '2022-05-10',
            'description' => '<p>The Raspberry Pi 4 Model B is the latest product in the popular Raspberry Pi range of computers. It offers ground-breaking increases in processor speed, multimedia performance, memory, and connectivity compared to the prior-generation Raspberry Pi 3 Model B+.</p>',
            'specification' => '<li>Processor: Broadcom BCM2711, quad-core Cortex-A72 (ARM v8) 64-bit SoC @ 1.5GHz</li>
                                <li>RAM: 2GB, 4GB, or 8GB LPDDR4-3200 SDRAM (depending on model)</li>
                                <li>Connectivity: 2.4 GHz and 5.0 GHz IEEE 802.11ac wireless, Bluetooth 5.0, BLE</li>
                                <li>GPIO: Standard 40-pin GPIO header (fully backwards-compatible with previous boards)</li>
                                <li>Video & Sound: 2 × micro HDMI ports (up to 4Kp60 supported), 2-lane MIPI DSI display port, 2-lane MIPI CSI camera port, 4-pole stereo audio and composite video port</li>
                                <li>Multimedia: H.265 (4Kp60 decode), H.264 (1080p60 decode, 1080p30 encode)</li>
                                <li>USB: 2 × USB 3.0 ports, 2 × USB 2.0 ports</li>
                                <li>Power: 5V DC via USB-C connector (minimum 3A*)</li>',
        ],
        [
            'id' => 4,
            'name' => 'ESP32',
            'brand' => 'Espressif',
            'price' => 50000,
            'stock' => 10,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8Xdw-0GVKen3wHT7fsLJM_uziCBnI_QytkA&s',
            'source' => 'Pak Joko',
            'date_arrived' => '2021-03-20',
            'last_maintained' => '2022-03-20',
            'description' => '<p>The ESP32 is a series of low-cost, low-power system on a chip microcontrollers with integrated Wi-Fi and dual-mode Bluetooth. The ESP32 series employs a Tensilica Xtensa LX6 microprocessor in both dual-core and single-core variations.</p>',
            'specification' => '<li>Microcontroller: Tensilica Xtensa LX6</li>
                                <li>Operating Voltage: 3.3V</li>
                                <li>Input Voltage: 7-12V</li>
                                <li>Input Voltage (limit): 6-20V</li>
                                <li>Digital I/O Pins: 36</li>
                                <li>Analog Input Pins: 18</li>
                                <li>DC Current per I/O Pin: 40 mA</li>
                                <li>DC Current for 3.3V Pin: 50 mA</li>
                                <li>Flash Memory: 4 MB</li>
                                <li>SRAM: 520 KB</li>
                                <li>EEPROM: 1 KB</li>
                                <li>Clock Speed: 240 MHz</li>',
        ],
        [
            'id' => 5,
            'name' => 'Breadboard',
            'brand' => 'Generic',
            'price' => 15000,
            'stock' => 20,
            'image' => 'https://sfxpcb.com/wp-content/uploads/2023/09/Breadboard.jpg.webp',
            'source' => 'Pak Agus',
            'date_arrived' => '2020-11-25',
            'last_maintained' => '2021-11-25',
            'description' => '<p>A breadboard is a construction base for prototyping of electronics. The term is commonly used to refer to a solderless breadboard (plugboard).</p>',
            'specification' => '<li>Material: ABS Plastic</li>
                                <li>Size: 16.5 x 5.5 x 0.85 cm</li>
                                <li>Terminal Strip: 640 tie points</li>
                                <li>Distribution Strip: 200 tie points</li>',
        ],
        [
            'id' => 6,
            'name' => 'Jumper Wires',
            'brand' => 'Generic',
            'price' => 5000,
            'stock' => 100,
            'image' => 'https://res.cloudinary.com/rsc/image/upload/b_rgb:FFFFFF,c_pad,dpr_2.0,f_auto,h_300,q_auto,w_600/c_pad,h_300,w_600/F7916454-01',
            'source' => 'Pak Rudi',
            'date_arrived' => '2020-12-01',
            'last_maintained' => '2021-12-01',
            'description' => '<p>Jumper wires are simply wires that have connector pins at each end, allowing them to be used to connect two points to each other without soldering.</p>',
            'specification' => '<li>Length: 20 cm</li>
                                <li>Color: Assorted</li>
                                <li>Connector Type: dupont</li>',
        ],
        [
            'id' => 7,
            'name' => 'LCD Display',
            'brand' => 'Hitachi',
            'price' => 30000,
            'stock' => 7,
            'image' => 'https://down-id.img.susercontent.com/file/edf478c40c6d45f3b9be6fe91809ab29',
            'source' => 'Pak Sigit',
            'date_arrived' => '2021-02-15',
            'last_maintained' => '2022-02-15',
            'description' => '<p>An LCD display is a flat-panel display or other electronically modulated optical device that uses the light-modulating properties of liquid crystals combined with polarizers.</p>',
            'specification' => '<li>Display Type: 16x2</li>
                                <li>Operating Voltage: 5V</li>
                                <li>Character Size: 5x8</li>
                                <li>Controller: HD44780</li>
                                <li>Interface: Parallel</li>',
        ],
        [
            'id' => 8,
            'name' => 'Servo Motor',
            'brand' => 'TowerPro',
            'price' => 40000,
            'stock' => 15,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQA8U3PvlmJYYSNpCRm618d01PK_YlybSm2cw&s',
            'source' => 'Pak Bambang',
            'date_arrived' => '2021-04-10',
            'last_maintained' => '2022-04-10',
            'description' => '<p>A servo motor is a rotary actuator or linear actuator that allows for precise control of angular or linear position, velocity, and acceleration.</p>',
            'specification' => '<li>Operating Voltage: 4.8-6V</li>
                                <li>Stall Torque: 1.8 kg/cm</li>
                                <li>Speed: 0.1 s/60°</li>
                                <li>Rotation: 180°</li>',
        ],
        [
            'id' => 9,
            'name' => 'Ultrasonic Sensor',
            'brand' => 'HC-SR04',
            'price' => 20000,
            'stock' => 25,
            'image' => 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEh7FTK0RCMiMrBNrnh19Clw1AtqnYTH9Vbm-hK4e0lEVcwKkBpzK0Al0kFypdSzfpGphlkS1e_N7qKouM9pKzQeG744OCyoEyQUmp5sgK3lfP0SIfjxOHAzspNfH8tGry-qsGrFcW1Wbg0tnXrzKs3SJZkg6XVqy2ulMZ5ZVVPI5uPKKCUOCTC6bkKa/s500/ultrasonic.jpg',
            'source' => 'Pak Dedi',
            'date_arrived' => '2021-06-05',
            'last_maintained' => '2022-06-05',
            'description' => '<p>The HC-SR04 is an ultrasonic sensor that uses sonar to determine distance to an object like bats or dolphins do. It offers excellent non-contact range detection with high accuracy and stable readings in an easy-to-use package.</p>',
            'specification' => '<li>Operating Voltage: 5V</li>
                                <li>Operating Current: 15mA</li>
                                <li>Operating Frequency: 40kHz</li>
                                <li>Max Range: 4m</li>
                                <li>Min Range: 2cm</li>',
        ],
        [
            'id' => 10,
            'name' => 'Relay Module',
            'brand' => 'Songle',
            'price' => 10000,
            'stock' => 30,
            'image' => 'https://digiwarestore.com/13005/relay-module-1-channel-5v-with-led-indicator-263068.jpg',
            'source' => 'Pak Eko',
            'date_arrived' => '2021-07-20',
            'last_maintained' => '2022-07-20',
            'description' => '<p>A relay module is a switch that is operated electrically. It is used to control a high-voltage circuit with a low-voltage signal, such as a digital signal from a microcontroller.</p>',
            'specification' => '<li>Operating Voltage: 5V</li>
                                <li>Control Voltage: 5V</li>
                                <li>Control Current: 15-20mA</li>
                                <li>Max Switching Voltage: 250VAC/30VDC</li>
                                <li>Max Switching Current: 10A</li>',
        ],
    ];

    public function showAllRegular()
    {
        return view('dashboard-reg-items', ['items' => $this->items]);
    }

    public function showAllAdmin()
    {
        return view('dashboard-admin-items', ['items' => $this->items]);
    }
    public function show($id)
    {
        $item = collect($this->items)->firstWhere('id', $id);

        return view('item-detail', ['item' => $item]);
    }
}

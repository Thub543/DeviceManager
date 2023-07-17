<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devicemodels = [
//------------------------------------------------------Smartphones------------------------------------------
//--------------------------------------------------Samsung--------------------------------

            ['model' => 'Galaxy S7',    'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S7 LTE 32 GB Schwarz',    'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy A53',    'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S22',    'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S21',    'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy Xcover 6 Pro',  'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy Xcover 5',  'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy Xcover 4',  'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy Xcover 4s',  'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],//10
            ['model' => 'Galaxy Xcover 3',  'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy Xcover 2',  'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy Xcover',  'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy A52s',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy A5 2016 LTE',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy A5 2017 LTE',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy A50',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy A6',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy A71',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy A8',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy Note 10',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy Note 9',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S10 Black',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S10e',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S20 EE',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S21 5G',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S21 EE',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S21+5G',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S21 Ultra 5G',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S22+',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S9',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S Advanced Schwarz',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S III i19300 16GB Blau',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S3 Mini',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S4 LTE +',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S4 Mini',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S5 LTE +',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Galaxy S5 Mini',             'vendor' => 'Samsung',  'type_id' => 1, 'os' => 'Android'],


//--------------------------------------------------Huawei--------------------------------
            ['model' => 'P30 pro',    'vendor' => 'Huawei',  'type_id' => 1, 'os' => 'Android'],
            ['model' => 'Mate 20 pro',    'vendor' => 'Huawei',  'type_id' => 1, 'os' => 'Android'],

//--------------------------------------------------Apple--------------------------------
            ['model' => 'Iphone 3GS',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone 4 16GB Schwarz',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone 4 32GB Schwarz',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone 4G/16GB',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone 4G/32GB',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone 4S 16GB Schwarz',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone 4S 16GB weiss',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone 4S 16GB ',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone 5 16GB Schwarz',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone 5 32GB Schwarz',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone 5S 16GB Schwarz',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone SE 64GB',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],

            ['model' => 'Iphone 12',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone 11 128G Black',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],
            ['model' => 'Iphone SE 2020',    'vendor' => 'Apple',  'type_id' => 1, 'os' => 'Ios'],

//--------------------------------------------------Nokia--------------------------------
            ['model' => '2330c',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => '2600',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => '2630',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => '3720 classic',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => '5310 Xpress Music',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => '6021',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => '6230i',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => '6300',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => '6300i',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => '6310i',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => 'C5',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => 'E52',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => 'E71',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],
            ['model' => 'E72',    'vendor' => 'Nokia',  'type_id' => 1, 'os' => null],

//--------------------------------------------------Blackberry--------------------------------
            ['model' => '8310',    'vendor' => 'Blackberry',  'type_id' => 1, 'os' => null],
            ['model' => '9000',    'vendor' => 'Blackberry',  'type_id' => 1, 'os' => null],
            ['model' => 'Bold 9000',    'vendor' => 'Blackberry',  'type_id' => 1, 'os' => null],
            ['model' => 'Curve 8310',    'vendor' => 'Blackberry',  'type_id' => 1, 'os' => null],


//--------------------------------------------------HTC--------------------------------
            ['model' => 'Cha Cha',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'Desire X',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'Diamond',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'Diamond 2',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'HD mini',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'HTC 10',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'Legend',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'One 4G',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'One A9',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'One M8 grau',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'One M9',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'One X',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],
            ['model' => 'Touch',    'vendor' => 'HTC',  'type_id' => 1, 'os' => null],

//--------------------------------------------------Sony--------------------------------
            ['model' => 'Xperia Go',    'vendor' => 'Sony',  'type_id' => 1, 'os' => null],
            ['model' => 'Xperia Z3 Compact',    'vendor' => 'Sony',  'type_id' => 1, 'os' => null],
            ['model' => 'Xperia Z5 Compact -',    'vendor' => 'Sony',  'type_id' => 1, 'os' => null],





//------------------------------------------------------Displays------------------------------------------
//--------------------------------------------------AOC--------------------------------
            ['model' => 'AOC E2260Pw',      'vendor' => 'AOC',  'type_id' => 3, 'os' => null],
            ['model' => 'E2260Pw',      'vendor' => 'AOC',  'type_id' => 3, 'os' => null],



//------------------------------------------------DELL----------------------------------
            ['model' => 'P2212H',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => 'P2214H',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => 'P2217H',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => 'P2219H',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => 'P2419H',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => 'P2422H',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => 'P2719H',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => 'S2715H',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => 'U2415',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => 'U2415B',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => 'P190S',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => '1908FPBLK',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],
            ['model' => '2007FPB',      'vendor' => 'DELL',  'type_id' => 3, 'os' => null],


//------------------------------------------------------Dockingstation------------------------------------------
//------------------------------------------------DELL----------------------------------

            ['model' => 'pro3x',      'vendor' => 'DELL',  'type_id' => 8, 'os' => null],
            ['model' => 'WD15',      'vendor' => 'DELL',  'type_id' => 8, 'os' => null],
            ['model' => 'WD19-130W',      'vendor' => 'DELL',  'type_id' => 8, 'os' => null],



//------------------------------------------------------Laptop------------------------------------------
//------------------------------------------------DELL----------------------------------
//--------------------------------------------WIN7----------------------------------
            ['model' => 'Latitude 5480',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN7'],
            ['model' => 'Latitude E 5450',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN7'],
            ['model' => 'Latitude E 5440',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN7'],

//--------------------------------------------WIN10----------------------------------

            ['model' => 'Inspiron 773',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 3400',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 3500',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 5285 2 in 1',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 5400',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 5401',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 5400',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 5410',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 5420',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 5490',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 5500',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 5510',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 5511',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 7200 2in1', 'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 7210',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 7390',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude 7410',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'Latitude E 5470',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],
            ['model' => 'XPS13',      'vendor' => 'DELL',  'type_id' => 6, 'os' => 'WIN10'],



//------------------------------------------------------Navigation------------------------------------------
//--------------------------------------------------Navigion------------------------------------------

            ['model' => '40 Easy',      'vendor' => 'Navigon',  'type_id' => 7, 'os' => null],

//--------------------------------------------------Becker------------------------------------------

            ['model' => 'Becker Traffic Assist Z107',    'vendor' => 'Becker',  'type_id' => 7, 'os' => null],
            ['model' => 'Ready 43',    'vendor' => 'Becker',  'type_id' => 7, 'os' => null],
            ['model' => 'Ready 43 Traffic',    'vendor' => 'Becker',  'type_id' => 7, 'os' => null],
            ['model' => 'Ready 43 Traffic v2',    'vendor' => 'Becker',  'type_id' => 7, 'os' => null],


//--------------------------------------------------Garmin------------------------------------------

            ['model' => 'Drive 50 Europe LMT 6',    'vendor' => 'Garmin',  'type_id' => 7, 'os' => null],
            ['model' => 'Drive 60 Europe LMT 6',    'vendor' => 'Garmin',  'type_id' => 7, 'os' => null],
            ['model' => 'Nüvi 1304T',    'vendor' => 'Garmin',  'type_id' => 7, 'os' => null],
            ['model' => 'Nüvi 2545 LMT',    'vendor' => 'Garmin',  'type_id' => 7, 'os' => null],
            ['model' => 'Nüvi 2547 LMT',    'vendor' => 'Garmin',  'type_id' => 7, 'os' => null],
            ['model' => 'Nüvi 2597 LMT',    'vendor' => 'Garmin',  'type_id' => 7, 'os' => null],
            ['model' => 'Nüvi 2599 LMT',    'vendor' => 'Garmin',  'type_id' => 7, 'os' => null],
            ['model' => 'Nüvi 40',    'vendor' => 'Garmin',  'type_id' => 7, 'os' => null],

//--------------------------------------------------TomTom------------------------------------------

            ['model' => 'TomTom',    'vendor' => 'TomTom',  'type_id' => 7, 'os' => null],
            ['model' => 'VIA 120 Europe Traffic',    'vendor' => 'TomTom',  'type_id' => 7, 'os' => null],
            ['model' => 'XL 2 IQ Routes Edition',    'vendor' => 'TomTom',  'type_id' => 7, 'os' => null],
            ['model' => 'XL Clasic Traffic Black Edition',    'vendor' => 'TomTom',  'type_id' => 7, 'os' => null],





//------------------------------------------------------Printer------------------------------------------
//--------------------------------------------------Ricoh------------------------------------------

            ['model' => 'Aficio MP 3001',    'vendor' => 'Ricoh',  'type_id' => 4, 'os' => null ],
            ['model' => 'Aficio SP C242DN',    'vendor' => 'Ricoh',  'type_id' => 4, 'os' => null ],
            ['model' => 'Aficio SP C320DN',    'vendor' => 'Ricoh',  'type_id' => 4, 'os' => null ],
            ['model' => 'IM C3000 ',    'vendor' => 'Ricoh',  'type_id' => 4, 'os' => null ],
            ['model' => 'IMP C2003 ',    'vendor' => 'Ricoh',  'type_id' => 4, 'os' => null ],
            ['model' => 'MP C3004 ',    'vendor' => 'Ricoh',  'type_id' => 4, 'os' => null ],
            ['model' => 'MP C3004ex ',    'vendor' => 'Ricoh',  'type_id' => 4, 'os' => null ],
            ['model' => 'MP C306Z ',    'vendor' => 'Ricoh',  'type_id' => 4, 'os' => null ],
            ['model' => 'SP 4510DN ',    'vendor' => 'Ricoh',  'type_id' => 4, 'os' => null ],
            ['model' => 'bizhub C650i',       'vendor' => 'Konica Minolta',     'type_id' => 4, 'os' => null, ],
            ['model' => 'bizhub C750i',       'vendor' => 'Konica Minolta',     'type_id' => 4, 'os' => null, ],
            ['model' => 'bizhub C300i',       'vendor' => 'Konica Minolta',     'type_id' => 4, 'os' => null, ],






//------------------------------------------------------Tablets------------------------------------------
//--------------------------------------------------Samsung--------------------------------

            ['model' => 'Galaxy Tab S7 FE',     'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],
            ['model' => 'Galaxy Tab S7 +',     'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],
            ['model' => 'Galaxy Tab S8',        'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],
            ['model' => 'Galaxy Tab A8',        'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],
            ['model' => 'Galaxy Active 2',     'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],
            ['model' => 'Galaxy Active 3',     'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],
            ['model' => 'Galaxy Active TAB Pro',     'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],
            ['model' => 'Galaxy Note 8.0 Weiss',     'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],
            ['model' => 'Galaxy S2 8.0 Weiss',     'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],
            ['model' => 'Galaxy S2 8.0 Schwarz',     'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],
            ['model' => 'Galaxy TAB S 8.4 Weiss',     'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],
            ['model' => 'Galaxy TAB S5e ',     'vendor' => 'Samsung',  'type_id' => 2, 'os' => 'Android'],

//--------------------------------------------------Apple--------------------------------

            ['model' => 'iPAD Air (4th Gen) ',     'vendor' => 'Apple',  'type_id' => 2, 'os' => 'Ios'],



//------------------------------------------------------Workingstation------------------------------------------
//--------------------------------------------------DELL--------------------------------
//-----------------------------------------------WIN7---------------------------
            ['model' => 'Optiplex360',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN7'],
            ['model' => 'Optiplex 3010',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN7'],
            ['model' => 'Optiplex 3020',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN7'],
            ['model' => 'T1600',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN7'],


//-----------------------------------------------WIN8---------------------------
            ['model' => 'Precision Tower 5810',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN8'],


//-----------------------------------------------WIN10---------------------------

            ['model' => 'Optiplex 3010',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN10'],

            ['model' => 'Optiplex 3020',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN10'],

            ['model' => 'Optiplex 3050',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN10'],

            ['model' => 'Optiplex 3060',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN10'],
            ['model' => 'Optiplex 3070',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN10'],
            ['model' => 'Optiplex 3080',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN10'],

            ['model' => 'Optiplex 790',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN10'],
            ['model' => 'Optiplex 7780 All In One',     'vendor' => 'DELL',  'type_id' => 9, 'os' => 'WIN10'],

//--------------------------------------------------Apple--------------------------------
            ['model' => 'iMac',     'vendor' => 'Apple',  'type_id' => 9, 'os' => null],





//--------------------------------------Test Fälle Tristan-----------------------
            ['model' => 'MacBook Pro M1',       'vendor' => 'Apple',     'type_id' => 6, 'os' => 'Macos',],
            ['model' => 'VivoBook F515',       'vendor' => 'Asus',     'type_id' => 6, 'os' => 'Macos',],
            ['model' => 'Pavilion Plus 14',       'vendor' => 'HP',     'type_id' => 6, 'os' => 'Macos',],


            ['model' => ' X27q',       'vendor' => 'HP',     'type_id' => 3, 'os' => null,],

            ['model' => ' nüvi 2597 LMT',       'vendor' => 'Garmin',     'type_id' => 7, 'os' => null,],
        ];

        DB::table('devicemodels')->insert($devicemodels);
    }
}

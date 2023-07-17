<?php

namespace App\Exports;

use App\Models\Device;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DeviceFilterExport implements FromCollection,ShouldAutoSize, WithHeadings
{


    protected $devices;

    public function __construct($devices)
    {
        $this->devices = $devices;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->devices;
    }

    public function headings(): array
    {
        return ['Inventory_Number', 'Status','Location', 'Model', 'Vendor', 'Current_Firstname','Current_Surname','Last_Firstname','Last_Surname', 'OrderID','Order_Date','Warranty','Serial/Tag','IMEI'];
    }


}

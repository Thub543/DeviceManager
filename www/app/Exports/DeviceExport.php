<?php

namespace App\Exports;

use App\Models\Device;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DeviceExport implements FromCollection,ShouldAutoSize, WithHeadings
{
    /**
     * Returns all devices with their information
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Device::join('statuses as s', 'devices.status_id', '=', 's.id')
            ->join('devicemodels as dm', 'devices.devicemodel_id', '=', 'dm.id')
            ->join('orders as o', 'devices.order_id', '=', 'o.id')
            ->join('locations as l', 'devices.location_id', '=', 'l.id')
            ->join('types as t', 'dm.type_id', '=', 't.id')
            ->leftjoin('employees as current', 'devices.current_employee_id', '=', 'current.id')
            ->leftjoin('employees as last', 'devices.last_employee_id', '=', 'last.id')
            ->select(
                'devices.inventory_id',
                's.status_name',
                'l.location_name',
                'dm.model',
                'dm.vendor',
                't.type_name',
                'current.firstname as current_firstname',
                'current.surname as current_surname',
                'last.firstname as last_firstname',
                'last.surname as last_surname',
                'o.order_id',
                'o.order_date',
                'devices.warranty',
                'devices.serial_tag',
                'devices.imei'
            )->get();
    }

    /**
     * Returns the headings for the excel sheet
     *
     * @return array
     */
    public function headings(): array
    {
        return ['Inventory_Number', 'Status','Location', 'Model', 'Vendor', 'Type', 'Current_Firstname','Current_Surname','Last_Firstname','Last_Surname', 'OrderID','Order_Date','Warranty','Serial/Tag','IMEI'];
    }


}

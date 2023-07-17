<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings,ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Employee::join('locations as l', 'employees.location_id', '=', 'l.id')
            ->select('firstname', 'surname','personal_number','l.location_initials')->get();
    }

    public function headings(): array
    {
        return ["Firstname", "Surname","Personal_Number", "Location_Initials"];
    }
}

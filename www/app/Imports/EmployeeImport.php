<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeeImport implements ToModel, WithValidation, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Employee([
            'firstname' => $row[0],
            'surname' => $row[1],
            'personal_number' => $row[2],
            'location_id' => Location::where('location_initials', strtoupper($row['3']))->firstOrFail()->id
        ]);
    }


    public function rules(): array
    {
        return [
            '0' => 'required|max:100|min:2',
            '1' => 'required|max:100|min:2',
            '2' => 'nullable|max:15|min:2|unique:employees,personal_number',
            '3' => 'required|exists:locations,location_initials',
        ];
    }

    /**
     * to skip the first row
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}

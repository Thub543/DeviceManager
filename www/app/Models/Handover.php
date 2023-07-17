<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Handover extends Model
{
    use Sortable, HasFactory;

    protected $fillable = ['handover_date','return_date','device_id', 'employee_id','user_id', 'created_at', 'updated_at'];
    public $sortable = ['handover_date','return_date'];
    protected $dates = ['handover_date','return_date'];

    public function device(){
        return $this->belongsTo(Device::class, 'device_id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function scopeDeviceHistory($query, $selectedDevices){
        return $query->join('employees', 'employees.id', '=', 'handovers.employee_id')
            ->where('device_id', $selectedDevices)
            ->whereNotNull('return_date')
            ->select('firstname','surname','handover_date','return_Date')
            ->orderby('handover_date','desc');
    }

    public function scopeDisplayHandovers($query, $status = null, $isReturnDateNull = null) {
        $query->join('devices as d','handovers.device_id','=','d.id')
            ->join('employees as e','e.id','=','handovers.employee_id')
            ->join('locations as l','e.location_id','=','l.id')
            ->join('devicemodels as dm','dm.id','=','d.devicemodel_id')
            ->join('users as u','u.id','=','handovers.user_id')
            ->sortable()
            ->select(
                'handovers.id',
                'e.firstname',
                'e.surname',
                'd.inventory_id',
                'handovers.handover_date',
                'handovers.return_date',
                'handovers.device_id',
                'dm.model',
                'l.location_initials',
                'u.username'
            );

        if ($isReturnDateNull) {
            $query->whereNull('handovers.return_date');
        }

        if ($status) {
            $statusId = Status::getIdByName($status);
            $query->where('d.status_id', $statusId);
        }

        return $query;
    }

    public function scopeSearchHandovers($query, $q, $status = null, $isReturnDateNull = false) {
        $searchFields = [
            'e.firstname',
            'e.surname',
            'device_id',
            'e.personal_Number',
            'handover_Date',
            'return_date',
            'l.location_initials',
            'l.location_name',
            'd.inventory_id',
            'dm.model',
            't.type_name',
            't.type_initials',
            'u.username'
        ];

        $query->join('employees as e','handovers.employee_id','=','e.id')
            ->join('devices as d', 'handovers.device_id', '=', 'd.id')
            ->join('devicemodels as dm', 'd.devicemodel_id', '=', 'dm.id')
            ->join('types as t', 'dm.type_id', '=', 't.id')
            ->join('users as u', 'handovers.user_id', '=', 'u.id')
            ->join('locations as l', 'e.location_id', '=', 'l.id')
            ->sortable()
            ->select([
                'handovers.id',
                'e.firstname',
                'e.surname',
                'd.inventory_id',
                'handovers.handover_date',
                'handovers.device_id',
                'dm.model',
                'l.location_initials',
                'u.username'
            ]);

        if ($status) {
            $query->where('d.status_id', Status::getIdByName($status));
        }

        if ($isReturnDateNull) {
            $query->whereNull('return_date');
        }

        $query->where(function($query) use ($q, $searchFields) {
            foreach($searchFields as $field){
                $query->orWhere($field, 'like', '%'.$q.'%');
            }
            $query->orWhereRaw("concat(e.firstname, ' ', e.surname) LIKE ?", ["%{$q}%"]); // add the full name search here
            $query->orWhereRaw("concat(e.surname, ' ', e.firstname) LIKE ?", ["%{$q}%"]); // add the full name search here
        });

        return $query;
    }





}

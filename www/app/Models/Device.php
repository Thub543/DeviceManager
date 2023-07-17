<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Device extends Model
{
    use Sortable, HasFactory;

    protected $fillable = ['inventory_id', 'order_id','warranty', 'serial_tag', 'imei', 'comment', 'location_id', 'devicemodel_id', 'status_id','last_employee_id','current_employee_id','user_id'];
    public $sortable = ['inventory_id','order_id','status_id','devicemodel_id'];
    protected $dates = ['order_date','warranty'];


    public function devicemodel(){
        return $this->belongsTo(DeviceModel::class, 'devicemodel_id');
    }

    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function lastEmployee()
    {
        return $this->belongsTo(Employee::class, 'last_employee_id');
    }

    public function currentEmployee()
    {
        return $this->belongsTo(Employee::class, 'current_employee_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function handovers(){
        return $this->hasMany(Handover::class);
    }



    public function scopeGetIdFromInvId($query, $invid){
        return $query->where('inventory_id', $invid)->value('id');
    }

    public function scopeGetInvId($query, $id){
        return $query->where('id', $id)->value('inventory_id');
    }

    public function scopeIsInStore($query, $id){
        return $query->where('id', $id)
            ->where('status_id', Status::getIdByName('in Store'))
            ->exists();
    }

    public function scopeIsAvailableForOnboarding($query, $bool, $invid){
        return $query->join('devicemodels as d', 'devices.devicemodel_id', '=', 'd.id')
            ->join('types', 'd.type_id', '=', 'types.id')
            ->where('types.isStationary', $bool)
            ->where('inventory_id', $invid)
            ->where('status_id', Status::getIdByName('in Store'))
            ->exists();
    }

    public function scopeIsAssigned($query, $id){
        return $query->where('id', $id)
            ->where('status_id', Status::getIdByName('assigned'))
            ->exists();
    }

    public function scopeFilterStatus($query, $selectedStatus){
        return $query->whereIn('status_id', $selectedStatus);
    }

    public function scopeOrders($query){
        return $query->groupBy('order_id');
    }

    public function scopeIsStationary($query, $bool)
    {
        return $query->join('devicemodels as d', 'devices.devicemodel_id', '=', 'd.id')
            ->join('types', 'd.type_id', '=', 'types.id')
            ->where('types.isStationary', $bool)
            ->select('devices.*');
    }

    public function scopeIsStationaryDevice($query, $bool, $invId)
    {
        return $query->join('devicemodels as d', 'devices.devicemodel_id', '=', 'd.id')
            ->join('types', 'd.type_id', '=', 'types.id')
            ->where('types.isStationary', $bool)
            ->where('devices.id', $invId)
            ->exists();
    }

    public function scopeOverviewDevices($query){
        return $query->sortable()
            ->select('devices.id as id',
                'inventory_id',
                'serial_tag',
                'imei',
                's.status_name as deviceState',
                'dm.vendor',
                'dm.model',
                'o.id as oid',
                'o.order_id as deviceOrderId',
                'currentEmployee.firstname as current_firstname',
                'currentEmployee.surname as current_surname',
                DB::raw('COALESCE(empLocation.location_initials, l.location_initials) as current_location_initials'),
                'lastEmployee.firstname as last_firstname',
                'lastEmployee.surname as last_surname',
                'devices.comment')
            ->leftJoin('employees AS lastEmployee', 'devices.last_employee_id', '=', 'lastEmployee.id')
            ->leftJoin('employees AS currentEmployee', 'devices.current_employee_id', '=', 'currentEmployee.id')
            ->leftJoin('locations AS empLocation', 'currentEmployee.location_id', '=', 'empLocation.id')
            ->leftJoin('locations AS l', 'devices.location_id', '=', 'l.id')
            ->join('statuses AS s', 'devices.status_id', '=', 's.id')
            ->join('orders AS o', 'devices.order_id', '=', 'o.id')
            ->join('devicemodels AS dm', 'devices.devicemodel_id', '=', 'dm.id');
    }


    public function scopeSearchDevices($q, $query, $selectedStatus){
        return $q->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('inventory_id', 'like', "%$query%")
                ->orWhere('serial_tag', 'like', "%$query%")
                ->orWhere('imei', 'like', "%$query%")
                ->orWhereHas('order', function ($q) use ($query) {
                    $q->where('order_id', 'like', "%$query%")
                        ->orWhereDate('order_date', 'like', "%$query%");
                })
                ->orWhereHas('currentEmployee.location', function ($q) use ($query) {
                    $q->where('firstname', 'like', "%$query%")
                        ->orWhere('surname', 'like', "%$query%")
                        ->orWhere('location_name', 'like', "%$query%")
                        ->orWhere('location_initials', 'like', "%$query%")
                        ->orWhere('personal_number', 'like', "%$query%")
                        ->orWhere(DB::raw("concat(firstname, ' ',surname)"), 'LIKE', "%" . $query . "%")
                        ->orWhere(DB::raw("concat(surname, ' ',firstname)"), 'LIKE', "%" . $query . "%");
                })
                ->orWhereHas('lastEmployee', function ($q) use ($query) {
                    $q->where('firstname', 'like', "%$query%")
                        ->orWhere('surname', 'like', "%$query%")
                        ->orWhere(DB::raw("concat(firstname, ' ',surname)"), 'LIKE', "%" . $query . "%")
                        ->orWhere(DB::raw("concat(surname, ' ',firstname)"), 'LIKE', "%" . $query . "%");
                })
                ->orWhereHas('status', function ($q) use ($query) {
                    $q->where('status_name', 'like', "%$query%");
                })
                ->orWhereHas('location', function ($q) use ($query) {
                    $q->where('location_initials', 'like', "%$query%");
                })
                ->orWhereHas('devicemodel.types', function ($q) use ($query) {
                    $q->where('model', 'like', "%$query%")
                        ->orWhere('vendor', 'like', "%$query%")
                        ->orWhere('type_initials', 'like', "%$query%")
                        ->orWhere('type_name', 'like', "%$query%")
                        ->where('types.isStationary', false);
                });
        })
            ->when($selectedStatus->isNotEmpty(), function ($queryBuilder) use ($selectedStatus) {
                $queryBuilder->filterStatus($selectedStatus);
            })
            ->leftJoin('employees AS lastEmployee', 'devices.last_employee_id', '=', 'lastEmployee.id')
            ->leftJoin('employees AS currentEmployee', 'devices.current_employee_id', '=', 'currentEmployee.id')
            ->leftJoin('locations AS empLocation', 'currentEmployee.location_id', '=', 'empLocation.id')
            ->leftJoin('locations AS l', 'devices.location_id', '=', 'l.id')
            ->join('statuses AS s', 'devices.status_id', '=', 's.id')
            ->join('orders AS o', 'devices.order_id', '=', 'o.id')
            ->join('devicemodels AS dm', 'devices.devicemodel_id', '=', 'dm.id')
            ->sortable()
            ->select(
                'devices.id',
                'inventory_id',
                'serial_tag',
                'imei',
                's.status_name as deviceState',
                'dm.vendor',
                'dm.model',
                'o.id as oid',
                'o.order_id as deviceOrderId',
                'o.order_date as deviceOrderDate',
                'warranty',
                'currentEmployee.firstname as current_firstname',
                'currentEmployee.surname as current_surname',
                DB::raw('COALESCE(empLocation.location_initials, l.location_initials) as current_location_initials'),
                'lastEmployee.firstname as last_firstname',
                'lastEmployee.surname as last_surname',
                'devices.comment',
                'devices.updated_at'
            );
    }
}

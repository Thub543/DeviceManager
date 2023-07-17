<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Employee extends Model
{
    use Sortable, HasFactory;

    protected $fillable = ['firstname', 'surname', 'personal_number', 'location_id'];
    public $sortable = ['firstname', 'surname'];

    public function handover(){
        return $this->hasMany(Handover::class);
    }

    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function lastDevices()
    {
        return $this->hasMany(Device::class, 'last_employee_id');
    }

    public function currentDevices()
    {
        return $this->hasMany(Device::class, 'current_employee_id');
    }

    public function scopeupdateLocation($query, $id, $location_id){
        return $query->where('id', $id)
            ->update(['location_id' => $location_id]);
    }
}

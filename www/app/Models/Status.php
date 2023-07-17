<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Status extends Model
{
    use Sortable;

    protected $fillable = ['status_name'];
    public $sortable = ['status_name'];

    public function devices(){
        return $this->hasMany(Device::class);
    }

    public function scopeGetStatusesByName($query, $arr){
        return $query->whereIn('status_name', $arr);
    }

    public function scopeGetIdByName($query, $str){
        return $query->where('status_name', $str)->value('id');
    }

    public function scopeStatesForOffboarding($query){
        return $query->where('status_name', 'in Store')
            ->orWhere('status_name', 'offboarding')
            ->orWhere('status_name', 'repair')
            ->orWhere('status_name', 'damaged')
            ->orWhere('status_name', 'lost')
            ->orWhere('status_name', 'stolen')
            ->select('id', 'status_name');
    }

}

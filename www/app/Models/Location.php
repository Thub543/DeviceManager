<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Location extends Model
{
    use sortable, HasFactory;

    protected $fillable = ['location_initials', 'location_name'];
    public $sortable = ['location_initials', 'location_name'];

    public function devices(){
        return $this->hasMany(Device::class);
    }

    public function employees(){
        return $this->hasMany(Device::class);
    }


    public function ScopeGetIT($query){
        return $query->where('location_name','IT')->value('id');
    }
}

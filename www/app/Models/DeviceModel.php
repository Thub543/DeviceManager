<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    use HasFactory;

    protected $table = 'devicemodels';

    protected $fillable = ['model', 'vendor', 'isStationary', 'type_id', 'os'];
    public $sortable = ['model', 'vendor', 'type_id', 'os'];

    public function devices(){
        return $this->hasMany(Device::class);
    }

    public function types(){
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function scopeFilterStatus($query, $selectedTypes){
        return $query->whereIn('type_id', $selectedTypes);
    }
}

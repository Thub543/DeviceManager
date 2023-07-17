<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['type_name', 'type_initials', 'isStationary'];

    protected $casts = ['isStationary' => 'boolean'];

    public function devicemodels(){
        return $this->hasMany(DeviceModel::class);
    }
}

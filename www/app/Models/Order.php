<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use HasFactory,Sortable;

    protected $fillable = ['order_id', 'order_date'];
    protected $dates = ['order_date'];

    public function devices(){
        return $this->hasMany(Device::class);
    }
}

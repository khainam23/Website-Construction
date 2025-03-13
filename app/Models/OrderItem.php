<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'device_id', 'quantity', 'unit_price', 'subtotal'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}

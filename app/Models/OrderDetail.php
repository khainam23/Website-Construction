<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrderDetail extends Model
{
    protected $fillable = ['order_id', 'product_id', 'cost', 'quantity', 'rental_start_date', 'rental_end_date'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getDurationAttribute()
    {
        if ($this->rental_start_date && $this->rental_end_date) {
            $start = Carbon::createFromFormat('Y-m-d', $this->rental_start_date);
            $end = Carbon::createFromFormat('Y-m-d', $this->rental_end_date);

            if ($start->gt($end)) {
                return 0;
            }

            return $start->diffInDays($end);
        }
        return null;
    }
}

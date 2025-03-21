<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['id', 'product_id', 'path'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

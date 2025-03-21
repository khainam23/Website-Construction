<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_id',
        'infomations',
        'features',
        'applications',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

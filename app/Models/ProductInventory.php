<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    protected $primaryKey = 'product_id';
    protected $table = "product_inventories";
    protected $fillable = ['product_id', 'type', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

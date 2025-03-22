<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'category_id', 'description', 'price', 'type', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function productDescriptions()
    {
        return $this->hasOne(ProductDescription::class);
    }

    public function productInventories()
    {
        return $this->hasOne(ProductInventory::class, 'product_id');
    }
}

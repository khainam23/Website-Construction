<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'price', 'status', 'inventory_id'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}

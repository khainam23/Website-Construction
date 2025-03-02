<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id', 
        'quantity', 
        'status',
        'location'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}

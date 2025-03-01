<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['location', 'total_devices'];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Device",
 *     required={"name", "category", "price", "stock"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Device Name"),
 *     @OA\Property(property="category", type="string", example="Electronics"),
 *     @OA\Property(property="description", type="string", nullable=true, example="Device description"),
 *     @OA\Property(property="price", type="number", format="float", example=999.99),
 *     @OA\Property(property="stock", type="integer", example=10),
 *     @OA\Property(property="created_at", type="string", format="datetime"),
 *     @OA\Property(property="updated_at", type="string", format="datetime")
 * )
 */
class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'stock'
    ];

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

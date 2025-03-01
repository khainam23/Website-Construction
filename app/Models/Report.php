<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'sales_revenue', 'rental_revenue'];

    public static function generateReport()
    {
        return self::all();
    }
}

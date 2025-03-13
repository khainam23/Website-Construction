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
    
    /**
     * Ensure data exists for the given year
     * This method is called from ReportController
     */
    public static function ensureDataExists($year)
    {
        // Check if we have data for the given year
        $hasData = self::whereYear('date', $year)->exists();
        
        // If no data exists, create sample data
        if (!$hasData) {
            self::generateSampleData($year);
        }
    }

    /**
     * Generate sample data for reporting purposes
     */
    private static function generateSampleData($year)
    {
        // Generate 3 months of sample data
        $startDate = now()->setYear($year)->startOfMonth()->subMonths(2);
        $endDate = now()->setYear($year);
        
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            // Create entry for each day with random but realistic data
            $salesRevenue = mt_rand(10000000, 50000000); // Random amount between 10M and 50M VND
            $rentalRevenue = mt_rand(5000000, 25000000); // Random amount between 5M and 25M VND
            
            // Create or update the report for this date
            self::updateOrCreate(
                ['date' => $currentDate->format('Y-m-d')],
                [
                    'sales_revenue' => $salesRevenue,
                    'rental_revenue' => $rentalRevenue
                ]
            );
            
            $currentDate->addDay();
        }
    }
}

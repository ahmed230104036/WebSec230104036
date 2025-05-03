<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class VulnerableController extends Controller
{
    // Vulnerable search using DB::unprepared
    public function vulnerableSearch(Request $request)
    {
        $keywords = $request->input('keywords', '');
        
        // This is intentionally vulnerable to SQL injection
        $results = DB::unprepared("
            SELECT * FROM products 
            WHERE name LIKE '%{$keywords}%'
        ");
        
        // Since unprepared doesn't return results, we need to fetch them separately
        $products = DB::select("SELECT * FROM products");
        
        return view('vulnerable.search', compact('products', 'keywords'));
    }
    
    // Secure search using prepared statements
    public function secureSearch(Request $request)
    {
        $keywords = $request->input('keywords', '');
        
        // This is secure against SQL injection
        $products = DB::select("
            SELECT * FROM products 
            WHERE name LIKE ?
        ", ["%{$keywords}%"]);
        
        return view('vulnerable.search', compact('products', 'keywords'));
    }
    
    // Example of how to use DB::unprepared safely
    public function safeUnprepared()
    {
        // 1. Use for administrative tasks with hardcoded queries
        DB::unprepared("
            CREATE TABLE IF NOT EXISTS temp_stats (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255),
                count INT
            )
        ");
        
        // 2. If user input is needed, sanitize it thoroughly
        $tableName = 'products'; // This would normally come from user input
        $safeTableName = preg_replace('/[^a-zA-Z0-9_]/', '', $tableName); // Sanitize
        
        // Only proceed if the sanitized name matches the original (meaning it was safe)
        if ($safeTableName === $tableName) {
            DB::unprepared("
                SELECT COUNT(*) FROM {$safeTableName}
            ");
        }
        
        return "DB::unprepared examples executed";
    }
}

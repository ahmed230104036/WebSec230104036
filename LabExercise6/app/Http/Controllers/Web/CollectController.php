<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CollectController extends Controller
{
    public function collect(Request $request)
    {
        // Log all collected data
        Log::info('Data collected:', $request->all());
        
        // Return a simple response
        return response()->json([
            'status' => 'success',
            'message' => 'Data collected successfully',
            'data' => $request->all()
        ]);
    }
}

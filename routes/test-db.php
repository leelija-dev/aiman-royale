<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::get('/test-db', function() {
    try {
        // Test database connection
        DB::connection()->getPdo();
        
        // Check if table exists
        if (!Schema::hasTable('size_charts')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Table size_charts does not exist'
            ]);
        }
        
        // Get all records
        $records = DB::table('size_charts')->get();
        
        return response()->json([
            'status' => 'success',
            'database' => DB::connection()->getDatabaseName(),
            'table_exists' => true,
            'record_count' => $records->count(),
            'records' => $records
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});

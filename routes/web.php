<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::get('/test-sizechart', function() {
    try {
        // Test database connection
        DB::connection()->getPdo();
        
        // Check if table exists
        if (!Schema::hasTable('size_charts')) {
            return 'Table size_charts does not exist';
        }
        
        // Get count of records
        $count = DB::table('size_charts')->count();
        
        // Get first record if exists
        $record = $count > 0 ? DB::table('size_charts')->first() : null;
        
        return [
            'status' => 'connected',
            'database' => DB::connection()->getDatabaseName(),
            'table_exists' => true,
            'record_count' => $count,
            'first_record' => $record
        ];
        
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
    }
});

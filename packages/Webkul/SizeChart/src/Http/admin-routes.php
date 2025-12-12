<?php

Route::get('/admin/sizechart/test', function() {
    try {
        // Check database connection
        \DB::connection()->getPdo();
        
        // Check if table exists
        if (!\Schema::hasTable('size_charts')) {
            return 'size_charts table does not exist';
        }
        
        // Get record count
        $count = \DB::table('size_charts')->count();
        
        // Get first few records
        $records = \DB::table('size_charts')->take(5)->get();
        
        return [
            'status' => 'connected',
            'table_exists' => true,
            'record_count' => $count,
            'sample_records' => $records
        ];
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }
})->name('sizechart.test');

Route::group(['middleware' => ['web', 'admin', 'locale']], function () {

    Route::get('/admin/sizechart', 'Webkul\SizeChart\Http\Controllers\Admin\SizeChartController@index')->defaults('_config', [
        'view' => 'sizechart::admin.sizechart.index',
    ])->name('sizechart.admin.index');

    Route::get('/admin/sizechart/create', 'Webkul\SizeChart\Http\Controllers\Admin\SizeChartController@create')->defaults('_config', [
        'view' => 'sizechart::admin.sizechart.create',
    ])->name('sizechart.admin.index.create');

    Route::get('/admin/sizechart/edit/{id}', 'Webkul\SizeChart\Http\Controllers\Admin\SizeChartController@edit')->defaults('_config', [
        'view' => 'sizechart::admin.sizechart.edit',
    ])->name('sizechart.admin.index.edit');

    Route::post('/admin/sizechart/edit/{id}', 'Webkul\SizeChart\Http\Controllers\Admin\SizeChartController@update')->defaults('_config', [
        'view' => 'sizechart::admin.sizechart.edit',
    ])->name('sizechart.admin.index.update');

    Route::post('/admin/sizechart/create', 'Webkul\SizeChart\Http\Controllers\Admin\SizeChartController@store')->defaults('_config', [
        'view' => 'sizechart::admin.sizechart.index',
    ])->name('sizechart.admin.index.store');

    Route::post('/admin/sizechart/delete/{id}', 'Webkul\SizeChart\Http\Controllers\Admin\SizeChartController@destroy')->name('sizechart.admin.index.delete');

    Route::post('/admin/sizechart/massdelete', 'Webkul\SizeChart\Http\Controllers\Admin\SizeChartController@massDestroy')->defaults('_config', [
        'redirect' => 'sizechart.admin.index',
    ])->name('sizechart.admin.index.massdelete');

});

Route::group(['middleware' => ['web', 'locale']], function () {

    Route::get('/admin/sizechart/attribute', 'Webkul\SizeChart\Http\Controllers\Admin\SizeChartController@attributeOptions')->name('sizechart.admin.config.attribute');
    
    Route::get('/shop/sizechart/template/save', 'Webkul\SizeChart\Http\Controllers\Shop\SizeChartController@saveTemplate')->name('sizechart.shop.save.template');
});
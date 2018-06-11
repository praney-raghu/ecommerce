<?php

Route::group(
    [
        'middleware' => 'web',
        'prefix' => 'ecommerce',
        'namespace' => 'Modules\ECommerce\Http\Controllers'
    ],
    function () {
        Route::get('/', 'ECommerceController@index');
        Route::get('/admin/dashboard', 'AdminController@index')->name('dashboard');
        Route::get('/admin/category', 'CatalogController@categoryIndex')->name('category_index');
        Route::get('/admin/product', 'CatalogController@productIndex')->name('product_index');
    }
);

Route::group(
    [
        'middleware' => ['web', 'auth:admin'],
        'prefix' => config('neev.admin_route'),
        'as' => 'admin.',
        'namespace' => 'Modules\ECommerce\Http\Controllers\Admin'
    ],
    function () {
        // Catalog Routes
        Route::get('products', 'ProductController@index')->name('product.index');
        Route::get('products/create', 'ProductController@create')->name('product.create');
        Route::post('products', 'ProductController@store')->name('product.store');
        Route::get('products/edit/{product}', 'ProductController@edit')->name('product.edit');
        Route::put('products/edit/{product}', 'ProductController@update')->name('product.update');
        Route::delete('products/destroy/{product}', 'ProductController@destroy')->name('product.destroy');

        Route::get('category', 'CategoryController@index')->name('category.index');
        Route::get('category/create', 'CategoryController@create')->name('category.create');
        Route::post('category', 'CategoryController@store')->name('category.store');
        Route::get('category/edit/{category}', 'CategoryController@edit')->name('category.edit');
        Route::put('category/edit/{category}', 'CategoryController@update')->name('category.update');
        Route::delete('category/destroy/{category}', 'CategoryController@destroy')->name('category.destroy');

        Route::get('orders', 'OrderController@index')->name('order.index');
        Route::get('orders/create', 'OrderController@create')->name('order.create');
        Route::post('orders', 'OrderController@store')->name('order.store');
        Route::get('orders/edit/{order}', 'OrderController@edit')->name('order.edit');
        Route::put('orders/edit/{order}', 'OrderController@update')->name('order.update');
        Route::delete('orders/destroy/{order}', 'OrderController@destroy')->name('order.destroy');
        Route::post('orders/productdetail', 'OrderController@getProduct')->name('order.getProduct');

        Route::get('invoices', 'InvoiceController@index')->name('invoice.index');
        Route::get('invoices/create', 'InvoiceController@create')->name('invoice.create');
        Route::post('invoices', 'InvoiceController@store')->name('invoice.store');
        Route::get('invoices/edit/{invoice}', 'InvoiceController@edit')->name('invoice.edit');
        Route::put('invoices/edit/{invoice}', 'InvoiceController@update')->name('invoice.update');
        Route::delete('invoices/destroy/{invoice}', 'InvoiceController@destroy')->name('invoice.destroy');
        Route::post('invoices/orderdetail', 'InvoiceController@getOrder')->name('invoice.getOrder');
    }
);

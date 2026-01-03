<?php

use App\Http\Controllers\Api\V1\AddonController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\HealthController;
use App\Http\Controllers\Api\V1\ProductAddonController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProductVariantPriceController;
use App\Http\Controllers\Api\V1\VariantController;
use App\Http\Controllers\Api\V1\VariantOptionController;
use Illuminate\Support\Facades\Route;

Route::get('/health', [HealthController::class, 'index']);

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/variants', [VariantController::class, 'index'])->name('variants.index');
Route::post('/variants', [VariantController::class, 'store'])->name('variants.store');
Route::get('/variants/{variant}', [VariantController::class, 'show'])->name('variants.show');
Route::put('/variants/{variant}', [VariantController::class, 'update'])->name('variants.update');
Route::patch('/variants/{variant}', [VariantController::class, 'update'])->name('variants.update');
Route::delete('/variants/{variant}', [VariantController::class, 'destroy'])->name('variants.destroy');

Route::get('/variant-options', [VariantOptionController::class, 'index'])->name('variant-options.index');
Route::post('/variant-options', [VariantOptionController::class, 'store'])->name('variant-options.store');
Route::get('/variant-options/{variantOption}', [VariantOptionController::class, 'show'])->name('variant-options.show');
Route::put('/variant-options/{variantOption}', [VariantOptionController::class, 'update'])->name('variant-options.update');
Route::patch('/variant-options/{variantOption}', [VariantOptionController::class, 'update'])->name('variant-options.update');
Route::delete('/variant-options/{variantOption}', [VariantOptionController::class, 'destroy'])->name('variant-options.destroy');

Route::get('/product-variant-prices', [ProductVariantPriceController::class, 'index'])->name('product-variant-prices.index');
Route::post('/product-variant-prices', [ProductVariantPriceController::class, 'store'])->name('product-variant-prices.store');
Route::get('/product-variant-prices/{productVariantPrice}', [ProductVariantPriceController::class, 'show'])->name('product-variant-prices.show');
Route::put('/product-variant-prices/{productVariantPrice}', [ProductVariantPriceController::class, 'update'])->name('product-variant-prices.update');
Route::patch('/product-variant-prices/{productVariantPrice}', [ProductVariantPriceController::class, 'update'])->name('product-variant-prices.update');
Route::delete('/product-variant-prices/{productVariantPrice}', [ProductVariantPriceController::class, 'destroy'])->name('product-variant-prices.destroy');

Route::get('/addons', [AddonController::class, 'index'])->name('addons.index');
Route::post('/addons', [AddonController::class, 'store'])->name('addons.store');
Route::get('/addons/{addon}', [AddonController::class, 'show'])->name('addons.show');
Route::put('/addons/{addon}', [AddonController::class, 'update'])->name('addons.update');
Route::patch('/addons/{addon}', [AddonController::class, 'update'])->name('addons.update');
Route::delete('/addons/{addon}', [AddonController::class, 'destroy'])->name('addons.destroy');

Route::get('/product-addons', [ProductAddonController::class, 'index'])->name('product-addons.index');
Route::post('/product-addons', [ProductAddonController::class, 'store'])->name('product-addons.store');
Route::get('/product-addons/{productAddon}', [ProductAddonController::class, 'show'])->name('product-addons.show');
Route::put('/product-addons/{productAddon}', [ProductAddonController::class, 'update'])->name('product-addons.update');
Route::patch('/product-addons/{productAddon}', [ProductAddonController::class, 'update'])->name('product-addons.update');
Route::delete('/product-addons/{productAddon}', [ProductAddonController::class, 'destroy'])->name('product-addons.destroy');

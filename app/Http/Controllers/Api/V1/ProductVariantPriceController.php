<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductVariantPriceRequest;
use App\Http\Requests\UpdateProductVariantPriceRequest;
use App\Http\Resources\ProductVariantPriceResource;
use App\Models\ProductVariantPrice;
use Illuminate\Http\JsonResponse;

class ProductVariantPriceController extends Controller
{
    /**
     * Display a listing of product variant prices.
     */
    public function index(): JsonResponse
    {
        $query = ProductVariantPrice::query()->with(['product', 'variantOption']);

        // Filter by product_id
        if (request()->has('product_id')) {
            $query->where('product_id', request('product_id'));
        }

        // Filter by variant_option_id
        if (request()->has('variant_option_id')) {
            $query->where('variant_option_id', request('variant_option_id'));
        }

        // Filter by is_active status
        if (request()->has('is_active')) {
            $isActive = filter_var(request('is_active'), FILTER_VALIDATE_BOOLEAN);
            $query->where('is_active', $isActive);
        }

        $productVariantPrices = $query->paginate(15);

        return ProductVariantPriceResource::collection($productVariantPrices)->response();
    }

    /**
     * Store a newly created product variant price.
     */
    public function store(StoreProductVariantPriceRequest $request): JsonResponse
    {
        $productVariantPrice = ProductVariantPrice::create($request->validated());

        return (new ProductVariantPriceResource($productVariantPrice))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified product variant price.
     */
    public function show(ProductVariantPrice $productVariantPrice): JsonResponse
    {
        $productVariantPrice->load(['product', 'variantOption']);

        return (new ProductVariantPriceResource($productVariantPrice))->response();
    }

    /**
     * Update the specified product variant price.
     */
    public function update(UpdateProductVariantPriceRequest $request, ProductVariantPrice $productVariantPrice): JsonResponse
    {
        $productVariantPrice->update($request->validated());

        return (new ProductVariantPriceResource($productVariantPrice->fresh()))->response();
    }

    /**
     * Remove the specified product variant price.
     */
    public function destroy(ProductVariantPrice $productVariantPrice): JsonResponse
    {
        $productVariantPrice->delete();

        return response()->json([
            'message' => 'Product variant price deleted successfully',
        ], 200);
    }
}

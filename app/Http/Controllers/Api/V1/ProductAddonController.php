<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductAddonRequest;
use App\Http\Requests\UpdateProductAddonRequest;
use App\Http\Resources\ProductAddonResource;
use App\Models\ProductAddon;
use Illuminate\Http\JsonResponse;

class ProductAddonController extends Controller
{
    /**
     * Display a listing of product addons.
     */
    public function index(): JsonResponse
    {
        $query = ProductAddon::query()->with(['product', 'addon']);

        // Filter by product_id
        if (request()->has('product_id')) {
            $query->where('product_id', request('product_id'));
        }

        // Filter by addon_id
        if (request()->has('addon_id')) {
            $query->where('addon_id', request('addon_id'));
        }

        // Filter by is_active status
        if (request()->has('is_active')) {
            $isActive = filter_var(request('is_active'), FILTER_VALIDATE_BOOLEAN);
            $query->where('is_active', $isActive);
        }

        $productAddons = $query->paginate(15);

        return ProductAddonResource::collection($productAddons)->response();
    }

    /**
     * Store a newly created product addon.
     */
    public function store(StoreProductAddonRequest $request): JsonResponse
    {
        $productAddon = ProductAddon::create($request->validated());

        return (new ProductAddonResource($productAddon))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified product addon.
     */
    public function show(ProductAddon $productAddon): JsonResponse
    {
        $productAddon->load(['product', 'addon']);

        return (new ProductAddonResource($productAddon))->response();
    }

    /**
     * Update the specified product addon.
     */
    public function update(UpdateProductAddonRequest $request, ProductAddon $productAddon): JsonResponse
    {
        $productAddon->update($request->validated());

        return (new ProductAddonResource($productAddon->fresh()))->response();
    }

    /**
     * Remove the specified product addon.
     */
    public function destroy(ProductAddon $productAddon): JsonResponse
    {
        $productAddon->delete();

        return response()->json([
            'message' => 'Product addon deleted successfully',
        ], 200);
    }
}

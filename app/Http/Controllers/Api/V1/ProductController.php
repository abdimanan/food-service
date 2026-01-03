<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(): JsonResponse
    {
        $query = Product::query()->with(['category', 'variantPrices.variantOption', 'productAddons.addon', 'media', 'tags']);

        // Filter by category_id
        if (request()->has('category_id')) {
            $query->where('category_id', request('category_id'));
        }

        // Filter by vendor_id
        if (request()->has('vendor_id')) {
            $query->where('vendor_id', request('vendor_id'));
        }

        // Filter by is_live status
        if (request()->has('is_live')) {
            $isLive = filter_var(request('is_live'), FILTER_VALIDATE_BOOLEAN);
            $query->where('is_live', $isLive);
        }

        // Filter by search term (name or slug)
        if (request()->has('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(15);

        return ProductResource::collection($products)->response();
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): JsonResponse
    {
        $product->load(['category', 'variantPrices.variantOption', 'productAddons.addon', 'media', 'tags']);

        return (new ProductResource($product))->response();
    }

    /**
     * Store a newly created product.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = DB::transaction(function () use ($request) {
            $validated = $request->validated();

            // Extract nested data
            $media = $validated['media'] ?? [];
            $tags = $validated['tags'] ?? [];

            // Remove nested data from product data
            unset($validated['media'], $validated['tags']);

            // Create product
            $product = Product::create($validated);

            // Create media
            if (! empty($media)) {
                foreach ($media as $mediaItem) {
                    $product->media()->create($mediaItem);
                }
            }

            // Create tags
            if (! empty($tags)) {
                foreach ($tags as $tag) {
                    $product->tags()->create($tag);
                }
            }

            return $product->load(['category', 'variantPrices.variantOption', 'productAddons.addon', 'media', 'tags']);
        });

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update the specified product.
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return (new ProductResource($product->load(['category', 'variantPrices.variantOption', 'productAddons.addon', 'media', 'tags'])))->response();
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
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
        $query = Product::query()->with(['category', 'variants', 'addons', 'media', 'tags']);

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
        $product->load(['category', 'variants', 'addons', 'media', 'tags']);

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
            $variants = $validated['variants'] ?? [];
            $addons = $validated['addons'] ?? [];
            $media = $validated['media'] ?? [];
            $tags = $validated['tags'] ?? [];

            // Remove nested data from product data
            unset($validated['variants'], $validated['addons'], $validated['media'], $validated['tags']);

            // Create product
            $product = Product::create($validated);

            // Create variants
            if (! empty($variants)) {
                foreach ($variants as $variant) {
                    $product->variants()->create($variant);
                }
            }

            // Create addons
            if (! empty($addons)) {
                foreach ($addons as $addon) {
                    $product->addons()->create($addon);
                }
            }

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

            return $product->load(['category', 'variants', 'addons', 'media', 'tags']);
        });

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }
}

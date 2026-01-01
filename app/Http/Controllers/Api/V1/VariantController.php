<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVariantRequest;
use App\Http\Requests\UpdateVariantRequest;
use App\Http\Resources\VariantResource;
use App\Models\Variant;
use Illuminate\Http\JsonResponse;

class VariantController extends Controller
{
    /**
     * Display a listing of variants.
     */
    public function index(): JsonResponse
    {
        $query = Variant::query()->with('options');

        // Filter by is_active status
        if (request()->has('is_active')) {
            $isActive = filter_var(request('is_active'), FILTER_VALIDATE_BOOLEAN);
            $query->where('is_active', $isActive);
        }

        // Filter by search term (name)
        if (request()->has('search')) {
            $search = request('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $variants = $query->paginate(15);

        return VariantResource::collection($variants)->response();
    }

    /**
     * Store a newly created variant.
     */
    public function store(StoreVariantRequest $request): JsonResponse
    {
        $variant = Variant::create($request->validated());

        return (new VariantResource($variant))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified variant.
     */
    public function show(Variant $variant): JsonResponse
    {
        $variant->load('options');

        return (new VariantResource($variant))->response();
    }

    /**
     * Update the specified variant.
     */
    public function update(UpdateVariantRequest $request, Variant $variant): JsonResponse
    {
        $variant->update($request->validated());

        return (new VariantResource($variant->fresh()))->response();
    }

    /**
     * Remove the specified variant.
     */
    public function destroy(Variant $variant): JsonResponse
    {
        $variant->delete();

        return response()->json([
            'message' => 'Variant deleted successfully',
        ], 200);
    }
}

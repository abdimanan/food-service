<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVariantOptionRequest;
use App\Http\Requests\UpdateVariantOptionRequest;
use App\Http\Resources\VariantOptionResource;
use App\Models\VariantOption;
use Illuminate\Http\JsonResponse;

class VariantOptionController extends Controller
{
    /**
     * Display a listing of variant options.
     */
    public function index(): JsonResponse
    {
        $query = VariantOption::query()->with('variant');

        // Filter by variant_id
        if (request()->has('variant_id')) {
            $query->where('variant_id', request('variant_id'));
        }

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

        $variantOptions = $query->paginate(15);

        return VariantOptionResource::collection($variantOptions)->response();
    }

    /**
     * Store a newly created variant option.
     */
    public function store(StoreVariantOptionRequest $request): JsonResponse
    {
        $variantOption = VariantOption::create($request->validated());

        return (new VariantOptionResource($variantOption))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified variant option.
     */
    public function show(VariantOption $variantOption): JsonResponse
    {
        $variantOption->load('variant');

        return (new VariantOptionResource($variantOption))->response();
    }

    /**
     * Update the specified variant option.
     */
    public function update(UpdateVariantOptionRequest $request, VariantOption $variantOption): JsonResponse
    {
        $variantOption->update($request->validated());

        return (new VariantOptionResource($variantOption->fresh()))->response();
    }

    /**
     * Remove the specified variant option.
     */
    public function destroy(VariantOption $variantOption): JsonResponse
    {
        $variantOption->delete();

        return response()->json([
            'message' => 'Variant option deleted successfully',
        ], 200);
    }
}

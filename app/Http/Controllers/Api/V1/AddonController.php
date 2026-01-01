<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddonRequest;
use App\Http\Requests\UpdateAddonRequest;
use App\Http\Resources\AddonResource;
use App\Models\Addon;
use Illuminate\Http\JsonResponse;

class AddonController extends Controller
{
    /**
     * Display a listing of addons.
     */
    public function index(): JsonResponse
    {
        $query = Addon::query();

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

        $addons = $query->paginate(15);

        return AddonResource::collection($addons)->response();
    }

    /**
     * Store a newly created addon.
     */
    public function store(StoreAddonRequest $request): JsonResponse
    {
        $addon = Addon::create($request->validated());

        return (new AddonResource($addon))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified addon.
     */
    public function show(Addon $addon): JsonResponse
    {
        return (new AddonResource($addon))->response();
    }

    /**
     * Update the specified addon.
     */
    public function update(UpdateAddonRequest $request, Addon $addon): JsonResponse
    {
        $addon->update($request->validated());

        return (new AddonResource($addon->fresh()))->response();
    }

    /**
     * Remove the specified addon.
     */
    public function destroy(Addon $addon): JsonResponse
    {
        $addon->delete();

        return response()->json([
            'message' => 'Addon deleted successfully',
        ], 200);
    }
}

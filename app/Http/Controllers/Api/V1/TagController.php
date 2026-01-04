<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    /**
     * Display a listing of tags.
     */
    public function index(): JsonResponse
    {
        $tags = Tag::query()->paginate(15);

        return TagResource::collection($tags)->response();
    }

    /**
     * Store a newly created tag.
     */
    public function store(StoreTagRequest $request): JsonResponse
    {
        $tag = Tag::create($request->validated());

        return (new TagResource($tag))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified tag.
     */
    public function show(Tag $tag): JsonResponse
    {
        return (new TagResource($tag))->response();
    }

    /**
     * Update the specified tag.
     */
    public function update(UpdateTagRequest $request, Tag $tag): JsonResponse
    {
        $tag->update($request->validated());

        return (new TagResource($tag->fresh()))->response();
    }

    /**
     * Remove the specified tag.
     */
    public function destroy(Tag $tag): JsonResponse
    {
        $tag->delete();

        return response()->json([
            'message' => 'Tag deleted successfully',
        ], 200);
    }
}

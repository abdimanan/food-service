<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vendor_id' => $this->vendor_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => (string) $this->price,
            'is_live' => $this->is_live,
            'preparation_time' => $this->preparation_time,
            'min_order_quantity' => $this->min_order_quantity,
            'variants' => ProductVariantResource::collection($this->whenLoaded('variants')),
            'addons' => ProductAddonResource::collection($this->whenLoaded('addons')),
            'media' => ProductMediaResource::collection($this->whenLoaded('media')),
            'tags' => ProductTagResource::collection($this->whenLoaded('tags')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}

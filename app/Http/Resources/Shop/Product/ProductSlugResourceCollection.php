<?php
 
namespace App\Http\Resources\Shop\Product;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
 
class AllProductSlugResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
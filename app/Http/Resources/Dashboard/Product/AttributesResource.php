<?php

namespace App\Http\Resources\Dashboard\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributesResource extends JsonResource
{

    private $itemsMustRemove = ['_id', 'product_id'];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $record = $this->getAttributes();
        $record['images_path'] = array_map(function ($item) {
            return env('APP_URL') . "/" . str_replace("public", "storage", $item);
        }, $record['images_path']);
        foreach ($this->itemsMustRemove as  $value) {
            unset($record[$value]);
        }

        return  $record;
    }
}

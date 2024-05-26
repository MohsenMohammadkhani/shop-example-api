<?php

namespace App\Http\Resources\auth;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    { 
        return $this->collection;
    }
}

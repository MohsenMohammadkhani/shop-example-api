<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductAttributes;
use App\Http\Resources\Dashboard\Product\AttributesResource as ProductAttributesResource;

class GetProduct
{
    private $productsImagesInstance;
    public function __construct()
    {
        $this->productsImagesInstance = new ProductsImages();
    }

    public function getListProduct()
    {
        return Product::select('id', 'title', 'slug', 'price')->paginate(10)->through(function ($product) {
            $productID = intval($product->id);
            $imagesProducts =  $this->productsImagesInstance->getImagesProduct($productID);
            $product['thumbnail-image'] =   env('APP_URL') . "/" . str_replace("public", "storage", $imagesProducts[0]);
            return $product;
        });
    }
}

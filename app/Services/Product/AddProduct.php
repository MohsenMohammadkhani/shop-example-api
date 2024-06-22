<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductAttributes;

class AddProduct
{

    private $productsImages;

    public function __construct()
    {
        $this->productsImages = new ProductsImages();
    }


    public function handler($productData)
    {
        $product = Product::create([
            "title" => $productData['title'],
            "slug" => $productData['slug'],
            "price" => $productData['price'],
            "description" => $productData['description'],
            "is_exist" => $productData['is_exist']
        ]);
        $imagesPath =  $this->productsImages->uploadImagesProduct($productData);
        ProductAttributes::create(
            [
                "images_path" => $imagesPath,
                "product_id" => $product->id,
                ...(array)  json_decode(stripslashes($productData['attributes']), true)
            ]
        );
    }
}

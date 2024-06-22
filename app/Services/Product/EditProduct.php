<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductAttributes;

class EditProduct
{

    private $productsImages;

    public function __construct()
    {
        $this->productsImages = new ProductsImages();
    }

    public function handler(int $productID, array  $productData)
    {
        $product = Product::findOrFail($productID);
        $product->update([
            "title" => $productData['title'],
            "slug" => $productData['slug'],
            "price" => $productData['price'],
            "description" => $productData['description'],
            "is_exist" => $productData['is_exist']
        ]);
        ProductAttributes::where('product_id', $productID)->first()->delete();
        $imagesPath = $this->getImagesPath($productData);
        ProductAttributes::create(
            [
                "images_path" => $imagesPath,
                "product_id" => $product->id,
                ...(array)  json_decode(stripslashes($productData['attributes']), true)
            ]
        );
    }

    private function getImagesPath($productData)
    {
        $imagesPath = [];
        if (intval($productData['count_images_upload'])  > 0) {
            $imagesPath =  $this->productsImages->uploadImagesProduct($productData);
        }

        $imagesPathUploaded = json_decode($productData['images_uploaded']);

        if (count($imagesPathUploaded) == 0) {
            return $imagesPath;
        }

        $imagesPathUploaded  = array_map(function ($item) {
            return  str_replace(env('APP_URL') . "/storage", "public", $item);
        }, $imagesPathUploaded);
        $imagesPath = [
            ...$imagesPath,
            ...$imagesPathUploaded
        ];
        return $imagesPath;
    }
}

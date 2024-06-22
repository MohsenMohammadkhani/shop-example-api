<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductAttributes;

class RemoveProduct
{

    private $productsImages;

    public function __construct()
    {
        $this->productsImages = new ProductsImages();
    }

    public function handler(int $productID)
    {
        Product::destroy($productID);
        $productAttributes =  ProductAttributes::where('product_id',  $productID)->first();
        ProductAttributes::destroy($productAttributes->id);
        $this->productsImages->removeProductImages($productAttributes->images_path);
    }
}

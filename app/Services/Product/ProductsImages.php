<?php

namespace App\Services\Product;

use Illuminate\Support\Facades\Storage;
use App\Models\ProductAttributes;

class ProductsImages
{

    public function getImagesProduct(int $productID)
    {
        $productAttributes = ProductAttributes::where('product_id', $productID)->first();
        return $productAttributes->images_path;
    }

    public function uploadImagesProduct($productData)
    {
        $imagesPath = [];
        $countImages = $productData['count_images_upload'];
        for ($counter = 0; $counter < $countImages; $counter++) {
            $image = $productData["file-$counter"];
            $fileExtension = $image->getClientOriginalExtension();
            $fileNameNumber = $counter + 1;
            $newFileName =  time() . "-$fileNameNumber.$fileExtension";
            $imagesPath[] = $image->storeAs('public/products', $newFileName);
        }
        return $imagesPath;
    }


    public function removeProductImages(array $imagesPath)
    {
        foreach ($imagesPath as $imagePath) {
            if (!Storage::exists($imagePath)) {
                continue;
            }
            Storage::delete($imagePath);
        }
    }
}

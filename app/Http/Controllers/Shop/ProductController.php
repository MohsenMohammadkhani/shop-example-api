<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Models\ProductAttributes;
use App\Services\Product\GetProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Dashboard\Product\AttributesResource as ProductAttributesResource;

class ProductController extends BaseController
{

    private $getProductsInstance;
    public function __construct()
    {
        $this->getProductsInstance = new GetProduct();
    }

    public function getListProduct(Request $request)
    {
        try {
            $products = $this->getProductsInstance->getListProduct($request);
            return $this->showResponse([
                'success' => true,
                'data' => $products
            ], 200);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            $this->showException(
                [
                    'result' => false,
                    'message' => __("shop/product.get_product_failed"),
                ],
                422
            );
        }
    }

    public function getAllProductSlug()
    {
        try {
            $productsSlug =  Product::select('slug')->paginate(10);
            return $this->showResponse([
                'success' => true,
                'data' => $productsSlug
            ], 200);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            $this->showException(
                [
                    'result' => false,
                    'message' => __("shop/product.get_product_failed"),
                ],
                422
            );
        }
    }

    public function show($slug)
    {
        try {
            $product = Product::where('slug', $slug)->first();
            if (!$product) {
                throw new \Exception(__("shop/product.get_product_failed"));
            }
            $product['attributes'] = new ProductAttributesResource(ProductAttributes::where('product_id',  $product->id)->first());

            return $this->showResponse([
                'success' => true,
                'data' => $product
            ], 200);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            $this->showException(
                [
                    'result' => false,
                    'message' => __("shop/product.get_product_failed"),
                ],
                422
            );
        }
    }
}

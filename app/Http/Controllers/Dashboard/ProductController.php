<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dashboard\Product\AddProductRequest;
use App\Http\Requests\Dashboard\Product\EditProductRequest;
use App\Models\Product;
use App\Models\ProductAttributes;
use Illuminate\Http\Request;
use App\Http\Resources\Dashboard\Product\AttributesResource as ProductAttributesResource;
use App\Http\Resources\Dashboard\Product\ProductResourceCollection;
use App\Services\Product\AddProduct;
use App\Services\Product\EditProduct;
use App\Services\Product\RemoveProduct;
use Illuminate\Support\Facades\Log;

class ProductController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $products = $this->getProductPaginate($request);
            return $this->showResponse([
                'success' => true,
                'products' => $products->response()->getData(true)
            ], 200);
        } catch (\Exception $error) {
            $this->showException(
                [
                    'success' => false,
                    'message' => $error->getMessage(),
                ],
                422
            );
        }
    }

    private function getProductPaginate(Request $request): ProductResourceCollection
    {
        if (!count($request->query())) {
            return new ProductResourceCollection(Product::paginate(10));
        }

        $queryString = collect($request->query());
        return new ProductResourceCollection(
            Product::filterByQueryString(
                $queryString
            )->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddProductRequest $request)
    {
        try {
            $addProductInstance = new AddProduct();
            $addProductInstance->handler($request->all());
            return $this->showResponse([
                'result' => true,
                'message' => __("dashboard/product.product_is_added"),
            ], 201);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            $this->showException(
                [
                    'result' => false,
                    'message' => __("dashboard/product.product_added_failed"),
                ],
                422
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product['attributes'] = new ProductAttributesResource(ProductAttributes::where('product_id',  $id)->first());
            return $this->showResponse([
                'result' => true,
                'data' => $product,
            ], 200);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            $this->showException(
                [
                    'result' => false,
                    'message' =>  __("dashboard/product.product_get_failed"),
                ],
                422
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditProductRequest $request, $id)
    {
        try {
            $editProductInstance = new EditProduct();
            $editProductInstance->handler($id, $request->all());
            return $this->showResponse([], 204);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            $this->showException(
                [
                    'result' => false,
                    'message' => __("dashboard/product.product_edit_failed"),
                ],
                422
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $removeProductInstance = new RemoveProduct();
            $removeProductInstance->handler($id);
            return $this->showResponse([], 204);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            $this->showException(
                [
                    'result' => false,
                    'message' => __("dashboard/product.product_remove_failed"),
                ],
                422
            );
        }
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttributes;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // try {
        //     $product = Product::findOrFailed();
        // } catch (\Exception $error) {
        //     $this->showException(
        //         [
        //             'success' => false,
        //             'message' => $error->getMessage(),
        //         ],
        //         422
        //     );
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $product = Product::create([
                "title" => $request->input('title'),
                "slug" => $request->input('slug'),
                "price" => $request->input('price')
            ]);
            $attributes = (array)  json_decode(stripslashes($request->input('attributes')), true);
            $attributes['product_id'] = $product->id;
            ProductAttributes::create($attributes);
            return $this->showResponse([
                'success' => true,
                'message' => __("product.product_is_added"),
            ], 201);
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
            $productAttributes = ProductAttributes::where('product_id',  $id)->first();
            $product['attributes'] = $productAttributes->attributesToArray();
            return $this->showResponse([
                'success' => true,
                'data' => $product,
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

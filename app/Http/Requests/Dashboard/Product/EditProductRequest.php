<?php

namespace App\Http\Requests\Dashboard\Product;

use App\Http\Requests\BaseRequests;
use Illuminate\Contracts\Validation\Validator;


class EditProductRequest extends BaseRequests
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $requestAll = $this->request->all();

        $countImagesUpload =  intval($requestAll['count_images_upload']);
        $countImagesUploaded =  intval($requestAll['count_images_uploaded']);

        if ($countImagesUpload == 0 &&   $countImagesUploaded == 0) {
            throw new \Exception("ddd");
        }

        $arrayRuleFileImage = [];
        if ($countImagesUpload > 0  ){
            for ($counter = 0; $counter < $countImagesUpload; $counter++) {
                $arrayRuleFileImage['file-' . $counter] = "mimes:jpeg,jpg,webp";
            }
        }
     
        $arrayRuleFileImage['images_uploaded'] = "required|json";
        return [
            'title' => 'required|string',
            'slug' => 'required|string',
            'price' => 'required|integer',
            'description' => 'required|string',
            'is_exist' => 'required|boolean',
            'attributes' => 'required|json',
            ...$arrayRuleFileImage
        ];
    }


    public function messages()
    {
        return [
            'title.required' => __('dashboard/product.title_is_not_entered'),
            'title.string' => __('dashboard/product.title_is_invalid'),

            'slug.required' => __('dashboard/product.slug_is_not_entered'),
            'slug.string' => __('dashboard/product.slug_is_invalid'),

            'price.required' => __('dashboard/product.price_is_not_entered'),
            'price.integer' => __('dashboard/product.price_is_invalid'),

            'description.required' => __('dashboard/product.description_is_not_entered'),
            'description.string' => __('dashboard/product.description_is_invalid'),

            'is_exist.required' => __('dashboard/product.is_exist_is_not_entered'),
            'is_exist.boolean' => __('dashboard/product.is_exist_is_invalid'),

            'attributes.required' => __('dashboard/product.attributes_is_not_entered'),
            'attributes.json' => __('dashboard/product.attributes_is_invalid'),

            'count_images.required' => __('dashboard/product.count_images_is_not_entered'),
            'count_images.json' => __('dashboard/product.count_images_is_invalid'),
            'count_images.min' => __('dashboard/product.count_images_is_invalid'),

            'images_uploaded.min' => __('dashboard/product.count_images_is_invalid'),

        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->showException([
            'success' => false,
            'message' => $validator->errors(),
        ], 422, [
            "Content-Type" => "application/json"
        ]);
    }
}

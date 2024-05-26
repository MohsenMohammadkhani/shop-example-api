<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequests extends FormRequest
{
    public function showException(array $response, int $statusCode, array $header = []): HttpResponseException
    {
        throw new HttpResponseException(response(
            $response
            , $statusCode, $header));
    }
}

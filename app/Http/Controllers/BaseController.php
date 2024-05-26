<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /***
     * @param array $body
     * @param int $statusCode
     * @return JsonResponse
     */
    public function showResponse(array $body,int $statusCode): JsonResponse
    {
        return response()->json(
            $body
            , $statusCode);
    }

    /***
     * @param array $response
     * @param int $statusCode
     * @param array $header
     * @return HttpResponseException
     */
    public function showException(array $response, int $statusCode, array $header = []): HttpResponseException
    {
        throw new HttpResponseException(response(
            $response
            , $statusCode, $header));
    }
}

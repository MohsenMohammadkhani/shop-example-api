<?php

use App\Services\Auth\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 
Route::prefix('v1')->group(function () {

    Route::prefix("dashboard")->namespace("Dashboard")->group(function () {
        Route::prefix("auth")->namespace("Auth")->group(function () {

            Route::get("/init", "AuthController@init")->middleware('tokenInHeaderMiddleware');

            Route::post("send-sms-code-login", "LoginController@sendSmsCodeForLogin");
            Route::post("login-with-sms-code", "LoginController@login");

            Route::resource("role", "RoleController")->middleware('permission:manage-roles');

            Route::get("permission/all-permission", "PermissionController@getAllPermissions");
            Route::resource("permission", "PermissionController")->middleware('permission:manage-permissions');
        });

        Route::resource("product", "ProductController")->middleware('permission:manage-products');
    });
});

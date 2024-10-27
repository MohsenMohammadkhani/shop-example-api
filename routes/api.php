<?php

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

        Route::prefix("user")->group(function () {
            Route::get("get-info", "UserController@getUserInfo")->middleware('permission:buy-product');
            Route::post("fill-info", "UserController@fillUserInfo")->middleware('permission:buy-product');
        });

        Route::resource("product", "ProductController")->middleware('permission:manage-products');
    });

    Route::prefix("shop")->namespace("Shop")->group(function () {

        Route::get("/products", "ProductController@getListProduct");
        Route::get("/products/all-products-slug", "ProductController@getAllProductSlug");
        Route::get("/products/{slug}", "ProductController@show");


        Route::get("/auth/login-with-sms-code", "LoginController@loginWithSmsCode");
        
        Route::post("/order", "OrderController@store")->middleware('permission:buy-product');;

    });
});

<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\permission\AddPermissionRequest;
use App\Http\Requests\Auth\permission\EditPermissionRequest;
use App\Http\Resources\Dashboard\auth\PermissionResourceCollection;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $permissions = $this->getPermissionsPaginate($request);
            return $this->showResponse([
                'success' => true,
                'permissions' => $permissions->response()->getData(true)
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

    private function getPermissionsPaginate(Request $request): PermissionResourceCollection
    {
        if (!count($request->query())) {
            return new PermissionResourceCollection(Permission::paginate(10));
        }
        $queryString = collect($request->query());
        return new PermissionResourceCollection(
            Permission::filterByQueryString(
                $queryString
            )->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddPermissionRequest $request): JsonResponse
    {
        try {
            Permission::create([
                "name" => $request->input('name'),
                "persian_name" => $request->input('persian_name'),
            ]);
            return $this->showResponse([
                'success' => true,
                'message' => __("auth.permission_is_added"),
            ], 201);
        } catch (\Exception $error) {
            $message = $error->getMessage();
            if ($error->getCode() == 23000) {
                $message = __('auth.permission_name_or_permission_persian_name_is_exist');
            };
            $this->showException(
                [
                    'success' => false,
                    'message' => $message,
                ],
                422
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $permission = Permission::findOrFail($id);
            return $this->showResponse([
                'success' => true,
                'data' => $permission->attributesToArray(),
            ], 200);
        } catch (\Exception $error) {
            $message = $error->getMessage();
            if ($error->getCode() == 0) {
                $message = __('auth.permission_with_this_permission_id_is_not_exist');
            };
            $this->showException(
                [
                    'success' => false,
                    'message' => $message,
                ],
                422
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPermissionRequest $request, $id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->update([
                "name" => $request->input('name'),
                "persian_name" => $request->input('persian_name'),
            ]);
            return $this->showResponse([], 204);
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


    public function getAllPermissions()
    {
        try {
            $allPermission = new PermissionResourceCollection(Permission::all());
            return $this->showResponse([
                "success" => true,
                "permissions" => $allPermission
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Permission::destroy($id);
            return $this->showResponse([], 204);
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
}

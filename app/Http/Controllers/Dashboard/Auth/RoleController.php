<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dashboard\Auth\role\AddRoleRequest;
use App\Http\Requests\Dashboard\Auth\role\EditRoleRequest;
use App\Http\Resources\Dashboard\auth\RoleResourceCollection;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $roles = $this->getRolesPaginate($request);
            return $this->showResponse([
                'success' => true,
                'roles' => $roles->response()->getData(true)
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRoleRequest $request)
    {
        try {
            $role = Role::create([
                "name" => $request->input('name'),
                "persian_name" => $request->input('persian_name'),
            ]);
            
            $permissionsIDS = $request->input('permissions_ids');
            $permissionsIDS = explode(",", $permissionsIDS);
            foreach ($permissionsIDS as $permissionID) {
                $role->permissions()->attach($permissionID);;
            }

            return $this->showResponse([
                'success' => true,
                'message' => __("auth.role_is_added"),
            ], 201);
        } catch (\Exception $error) {
            $message = $error->getMessage();
            if ($error->getCode() == 23000) {
                $message = __('auth.role_name_or_role_persian_name_is_exist');
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $role = Role::findOrFail($id);
            $result = array(
                "role" => $role->attributesToArray(),
                "permissions" => $role->permissions,
            );
            return $this->showResponse([
                'success' => true,
                'data' => $result,
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

    private function getRolesPaginate(Request $request): RoleResourceCollection
    {
        if (!count($request->query())) {
            return new RoleResourceCollection(Role::paginate(10));
        }
        $queryString = collect($request->query());
        return new RoleResourceCollection(
            Role::filterByQueryString(
                $queryString
            )->paginate(10)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRoleRequest $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->update([
                "name" => $request->input('name'),
                "persian_name" => $request->input('persian_name'),
            ]);

            $permissionsIDS = $request->input('permissions_ids');
            $permissionsIDS = explode(",", $permissionsIDS);
            $role->permissions()->detach();
            foreach ($permissionsIDS as $permissionID) {
                $role->permissions()->attach($permissionID);;
            }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Role::destroy($id);
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

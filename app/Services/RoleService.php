<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use App\Exceptions\MsgExeptions;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ServiceException;
use App\Http\Resources\RoleResource;
use App\Repositories\RoleRepository;
use App\Http\Resources\RoleCollection;

class RoleService
{
    /**
     * @var roleRepository
     */
    private RoleRepository $roleRepository;

    /**
     * @param $request
     * @return RoleCollection
     */
    public function findAll($request = null): RoleCollection
    {
        if ($request->has('paged') && $request->boolean('paged')) {
            return $this->getRoleRepository()->findAllPaginate();
        } else {
            return $this->getRoleRepository()->findAll();
        }
    }

    /**
     * @param $request
     * @return RoleResource
     * @throws ServiceException
     */
    public function addRole($request): RoleResource
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');

        try {
            $role->save();

            foreach ($request->input('permissions') as $key => $value) {
                $role->attachPermission($value);
            }

        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::ROLE['CREATE']['MSG'], MsgExeptions::ROLE['CREATE']['TYPE'], 422);
        }

        return new RoleResource($role);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws ServiceException
     */
    public function editRole(int $id): JsonResponse
    {
        $role = $this->showRole($id);
        $permissions = (new PermissionService())->findAll();

        return response()->json(['success' => true, 'code' => 200, 'data' => [$role, $permissions]], 200);
    }

    /**
     * @param $id
     * @return RoleResource
     * @throws ServiceException
     */
    public function showRole($id): RoleResource
    {
        try {
            $permission = $this->getRoleRepository()->find($id);
        } catch(\Exception $e)  {
            throw new ServiceException(MsgExeptions::ROLE['NOT_FOUND']['MSG'], MsgExeptions::ROLE['NOT_FOUND']['TYPE'], 404);
        }

        return new RoleResource($permission);

    }

    /**
     * @param $request
     * @param $id
     * @return RoleResource
     * @throws ServiceException
     */
    public function updateRole($request, $id): RoleResource
    {
        $input = $request->only('name', 'display_name', 'description');

        try {
            $role = Role::findOrFail($id);
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::USER['NOT_FOUND']['MSG'], MsgExeptions::USER['NOT_FOUND']['TYPE'], 404);
        }

        try {
            $role->update($input);

            DB::table("permission_role")->where("role_id",$id)->delete();

            foreach ($request->input('permissions') as $key => $value) {
                $role->attachPermission($value);
            }
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::ROLE['UPDATE']['MSG'], MsgExeptions::ROLE['UPDATE']['TYPE'], 404);
        }

        return $this->showRole($id);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws ServiceException
     */
    public function removeRole($id): JsonResponse
    {
        $idRole = $this->showRole($id)->id;

        try {
            $this->getRoleRepository()->delete($idRole);
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::ROLE['REMOVE']['MSG'], MsgExeptions::ROLE['REMOVE']['TYPE'], 404);
        }

        return response()->json(['success' => true], 410);
    }

    /**
     * @return RoleRepository|mixed
     */
    private function getRoleRepository(): RoleRepository
    {
        if (empty($this->roleRepository)) {
            $this->roleRepository = new RoleRepository();
        }

        return $this->roleRepository;
    }

}

<?php

namespace App\Services;

use App\Exceptions\MsgExeptions;
use App\Exceptions\ServiceException;
use App\Http\Resources\PermissionResource;
use App\Repositories\PermissionRepository;
use App\Http\Resources\PermissionCollection;
use Illuminate\Http\JsonResponse;

class PermissionService
{
    /**
     * @var permissionRepository
     */
    private PermissionRepository $permissionRepository;

    /**
     * @param $request
     * @return PermissionCollection
     */
    public function findAll($request = null): PermissionCollection
    {
        if ($request->has('paged') && $request->boolean('paged')) {
            return $this->getPermissionRepository()->findAllPaginate();
        } else {
            return $this->getPermissionRepository()->findAll();
        }
    }

    /**
     * @param $request
     * @return PermissionResource
     * @throws ServiceException
     */
    public function addPermission($request): PermissionResource
    {
        try {
            $permission = $this->getPermissionRepository()->create($request);
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::PERMISSION['CREATE']['MSG'], MsgExeptions::PERMISSION['CREATE']['TYPE'], 422);
        }

        return new PermissionResource($permission);
    }

    /**
     * @param $id
     * @return PermissionResource
     * @throws ServiceException
     */
    public function showPermission($id): PermissionResource
    {
        try {
            $permission = $this->getPermissionRepository()->find($id);
        } catch(\Exception $e)  {
            throw new ServiceException(MsgExeptions::PERMISSION['NOT_FOUND']['MSG'], MsgExeptions::PERMISSION['NOT_FOUND']['TYPE'], 404);
        }

        return new PermissionResource($permission);

    }

    /**
     * @param $request
     * @param $id
     * @return PermissionResource
     * @throws ServiceException
     */
    public function updatePermission($request, $id): PermissionResource
    {
        $input = $request->only('name', 'display_name', 'description');

        $idPermission = $this->showPermission($id)->id;

        try {
            $updatePermission = $this->getPermissionRepository()->update($input, $idPermission);
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::PERMISSION['UPDATE']['MSG'], MsgExeptions::PERMISSION['UPDATE']['TYPE'], 422);
        }

        return new PermissionResource($updatePermission);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws ServiceException
     */
    public function removePermission($id): JsonResponse
    {
        $idPermission = $this->showPermission($id)->id;

        try {
            $this->getPermissionRepository()->delete($idPermission);
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::PERMISSION['REMOVE']['MSG'], MsgExeptions::PERMISSION['REMOVE']['TYPE'], 422);
        }

        return response()->json(['success' => true], 410);
    }

    /**
     * @return PermissionRepository|mixed
     */
    private function getPermissionRepository(): PermissionRepository
    {
        if (empty($this->permissionRepository)) {
            $this->permissionRepository = new PermissionRepository();
        }

        return $this->permissionRepository;
    }

}

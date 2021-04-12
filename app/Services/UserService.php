<?php

namespace App\Services;

use App\Models\User;
use App\Exceptions\MsgExeptions;
use Illuminate\Http\JsonResponse;
use App\Exceptions\ServiceException;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserService
{
    /**
     * @var userRepository
     */
    private UserRepository $userRepository;


    /**
     * @param $request
     * @return JsonResponse
     */
    public function findAll($request = null): JsonResponse
    {
        if ($request->has('paged') && $request->boolean('paged')) {
            return $this->getUserRepository()->findAllUserWithRoleAndPermission()->response();
        } else {
            return $this->getUserRepository()->findAllUser()->response();
        }
    }

    /**
     * @param $id
     * @return UserResource
     * @throws ServiceException
     */
    public function showUser($id): UserResource
    {
        try {
            $user = $this->getUserRepository()->find($id);
        } catch(\Exception $e)  {
            throw new ServiceException(MsgExeptions::USER['NOT_FOUND']['MSG'], MsgExeptions::USER['NOT_FOUND']['TYPE'], 404);
        }

        return new UserResource($user);
    }

    /**
     * @param $request
     * @return mixed
     * @throws ServiceException
     */
    public function registerUser($request): UserResource
    {
        $input = $request->only('name', 'email', 'password');
        $input['password'] = app('hash')->make($input['password']);

        try {
            $user = User::create($input);
            $user->attachRole(3);
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::USER['CREATE']['MSG'], MsgExeptions::USER['CREATE']['TYPE'], 422);
        }

        return new UserResource($user);
    }

    /**
     * @param $request
     * @return mixed
     * @throws ServiceException
     */
    public function addUser($request): UserResource
    {
        $input = $request->only('name', 'email', 'password', 'roles');
        $input['password'] = app('hash')->make($input['password']);

        try {
            $user = User::create($input);

            if ($request->has('roles')) {
                foreach ($request->input('roles') as $key => $value) {
                    $user->attachRole($value);
                }
            }

        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::USER['CREATE']['MSG'], MsgExeptions::USER['CREATE']['TYPE'], 422);
        }

        return new UserResource($user);
    }

    /**
     * @param $request
     * @param $id
     * @return UserResource
     * @throws ServiceException
     */
    public function updateUser($request, $id): UserResource
    {
        $input = $request->only('name', 'email', 'roles');

        try {
            $user = User::findOrFail($id);
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::USER['NOT_FOUND']['MSG'], MsgExeptions::USER['NOT_FOUND']['TYPE'], 404);
        }

        try {
            $user->update($input);

            if ($request->has('roles')) {
                foreach ($request->input('roles') as $key => $value) {
                    $user->attachRole($value);
                }
            }

        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::USER['UPDATE']['MSG'], MsgExeptions::USER['UPDATE']['TYPE'], 422);
        }

        return $this->showUser($id);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws ServiceException
     */
    public function removeUser($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::USER['NOT_FOUND']['MSG'], MsgExeptions::USER['NOT_FOUND']['TYPE'], 422);
        }

        if($user->hasRole('super')) {
            throw new HttpResponseException(response()->json(
                [
                    "success" => false,
                    "code" => 401,
                    "message" => "Usuário não pode ser excluído."
                ], 401));
        }

        try {
            $this->getUserRepository()->delete($user->id);
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::USER['REMOVE']['MSG'], MsgExeptions::USER['CREATE']['TYPE'], 422);
        }

        return response()->json(['success' => true], 410);
    }

    /**
     * @return UserRepository|mixed
     */
    private function getUserRepository(): UserRepository
    {
        if (empty($this->userRepository)) {
            $this->userRepository = new UserRepository();
        }

        return $this->userRepository;
    }

}

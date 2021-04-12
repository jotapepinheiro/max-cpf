<?php

namespace App\Repositories;

use App\Models\User;
use App\Http\Resources\UserCollection;

class UserRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected array $fieldSearchable = [
        'id', 'name', 'email'
    ];

    /**
     * @return string[]
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * @return UserCollection
     */
    public function findAllUserWithRoleAndPermission(): UserCollection
    {
        $users = User::with(['roles.permissions'])->orderBy('id','DESC');

        return new UserCollection($users->paginate(10));
    }

    /**
     * @return UserCollection
     */
    public function findAllUser(): UserCollection
    {
        return new UserCollection(User::all());
    }

}

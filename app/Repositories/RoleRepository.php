<?php

namespace App\Repositories;

use App\Models\Role;
use App\Http\Resources\RoleCollection;

class RoleRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected array $fieldSearchable = [
        'name', 'display_name', 'description'
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
        return Role::class;
    }

    /**
     * @return RoleCollection
     */
    public function findAllPaginate(): RoleCollection
    {
        $permissions = Role::orderBy('id','DESC');

        return new RoleCollection($permissions->paginate(10));
    }

    /**
     * @return RoleCollection
     */
    public function findAll(): RoleCollection
    {
        return new RoleCollection(Role::all());
    }

}

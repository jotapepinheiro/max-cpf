<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Http\Resources\PermissionCollection;

class PermissionRepository extends BaseRepository
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
        return Permission::class;
    }

    /**
     * @return PermissionCollection
     */
    public function findAllPaginate(): PermissionCollection
    {
        $permissions = Permission::orderBy('id','DESC');

        return new PermissionCollection($permissions->paginate(10));
    }

    /**
     * @return PermissionCollection
     */
    public function findAll(): PermissionCollection
    {
        return new PermissionCollection(Permission::all());
    }

}

<?php

namespace App\Http\Responses\Role;

use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 *
 * @Schema(title="Auth Roles", description="Perfil de Usuário")
 *
 * @package App\Http\Responses\Role
 */
class RoleResource
{
    /**
     * @Property(type="integer", description="ID")
     *
     * @var int
     */
    public $id = 0;

    /**
     * @Property(type="string", description="name")
     *
     * @var string
     */
    public $name;

    /**
     * @Property(type="string", description="display name")
     *
     * @var string
     */
    public $display_name;

    /**
     * @Property(type="string", description="description")
     *
     * @var string
     */
    public $description;

    /**
     * @Property(type="string", description="createdAt")
     *
     * @var string
     */
    public $createdAt;

    /**
     * @Property(type="array", @Items(ref="#/components/schemas/PermissionContent"))
     *
     * @var array
     */
    public $permissions = [];

}

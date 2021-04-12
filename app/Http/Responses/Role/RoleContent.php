<?php

namespace App\Http\Responses\Role;

use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema(title="Auth Roles", description="Perfil de Usuário")
 *
 * @package App\Http\Responses\Role
 */
class RoleContent
{
    /**
     * @Property(type="array", @Items(ref="#/components/schemas/RoleResource"))
     *
     * @var array
     */
    public $Content = [];

}

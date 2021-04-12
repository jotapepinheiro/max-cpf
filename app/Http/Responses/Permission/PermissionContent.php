<?php

namespace App\Http\Responses\Permission;

use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema(title="Auth Permissions", description="Permissões de Usuário")
 *
 * @package App\Http\Responses\Permission
 */
class PermissionContent
{
    /**
     * @Property(type="array", @Items(ref="#/components/schemas/PermissionResource"))
     *
     * @var array
     */
    public $Content = [];

}

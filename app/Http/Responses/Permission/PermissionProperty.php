<?php

namespace App\Http\Responses\Permission;

use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 *
 * @Schema(title="Auth Permissions", description="Permissões de Usuário")
 *
 * @package App\Http\Responses\Permission
 */
class PermissionProperty
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
     * @Property(type="string", description="updatedAt")
     *
     * @var string
     */
    public $updatedAt;
}

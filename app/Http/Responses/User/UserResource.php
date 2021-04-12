<?php

namespace App\Http\Responses\User;

use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema(title="User", description="Usuário")
 *
 * @package App\Http\Responses\User
 */
class UserResource
{
    /**
     * @Property(type="integer", description="ID")
     *
     * @var int
     */
    public $id = 0;

    /**
     * @Property(type="string", description= "name")
     *
     * @var string
     */
    public $name;

    /**
     * @Property(type="string", description= "email")
     *
     * @var string
     */
    public $email;

    /**
     * @Property(type="string", description="createdAt")
     *
     * @var string
     */
    public $createdAt;

    /**
     * @Property(type="array", @Items(ref="#/components/schemas/RoleContent"))
     *
     * @var array
     */
    public $rules = [];

}

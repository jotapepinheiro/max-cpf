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
class UserProperty
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
     * @Property(type="string", description= "email_verified_at")
     *
     * @var string
     */
    public $email_verified_at;

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

    /**
     * @Property(type="array", @Items(ref="#/components/schemas/RoleProperty"))
     *
     * @var array
     */
    public $rules = [];
}

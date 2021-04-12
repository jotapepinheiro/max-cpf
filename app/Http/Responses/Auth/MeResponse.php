<?php

namespace App\Http\Responses\Auth;

use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema(title="Auth Me", description="Retorn dados do usuário")
 *
 * @package App\Http\Responses\Auth
 */
class MeResponse
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
    public $emailVerifiedAt;

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
     * @Property(type="array", @Items(ref="#/components/schemas/RoleWithPermissionsProperty"))
     *
     * @var array
     */
    public $rules = [];
}

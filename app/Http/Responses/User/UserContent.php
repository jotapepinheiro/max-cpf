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
class UserContent
{
    /**
     * @Property(type="array", @Items(ref="#/components/schemas/UserResource"))
     *
     * @var array
     */
    public $Content = [];

}

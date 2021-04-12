<?php

namespace App\Http\Responses\Cpf;

use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema(title="CPF", description="CPF")
 *
 * @package App\Http\Responses\Cpf
 */
class CpfProperty
{
    /**
     * @Property(type="integer", description="ID")
     *
     * @var int
     */
    public $id = 0;

    /**
     * @Property(type="integer", description="ID Usuário")
     *
     * @var int
     */
    public $user_id = 0;

    /**
     * @Property(type="string", description= "CPF")
     *
     * @var string
     */
    public $cpf;

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
     * @Property(type="array", @Items(ref="#/components/schemas/UserProperty"))
     *
     * @var array
     */
    public $user = [];
}

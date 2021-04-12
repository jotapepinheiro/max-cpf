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
class CpfResource
{
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

}

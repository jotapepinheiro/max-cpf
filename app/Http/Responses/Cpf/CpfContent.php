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
class CpfContent
{
    /**
     * @Property(type="array", @Items(ref="#/components/schemas/CpfResource"))
     *
     * @var array
     */
    public $Content = [];
}

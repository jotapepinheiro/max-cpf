<?php

namespace App\Http\Controllers;

use OpenApi\Annotations\Tag;
use OpenApi\Annotations\Info;
use OpenApi\Annotations\Server;
use OpenApi\Annotations\Schema;
use OpenApi\Annotations\Contact;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\SecurityScheme;
use OpenApi\Annotations\ExternalDocumentation;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 *
 * @Info(
 *     version="1.0.0",
 *     title="API - Max CPFs",
 *     description="Documentação do Projeto API Max CPFs",
 *     @Contact(
 *         email="joaopinheiro.ti@gmail.com.br",
 *         name="João Paulo Pinheiro"
 *     )
 * )
 * @Server(url="http://maxcpf.local/api/v1", description="Ambiente de Desenvolvimento")
 * @Server(url="http://maxcpf.prod/api/v1", description="Ambiente de Produção")
 *
 * @Tag(
 *     name="Login",
 *     description="Atenticar com JWT",
 *     @ExternalDocumentation(
 *        description="JWT",
 *        url="https://github.com/tymondesigns/jwt-auth"
 *     )
 * )
 *
 * @Tag(name="Auth", description="Meus Dados")
 * @Tag(name="CPFs", description="Manter CPFs")
 *
 * @Schema(
 *     schema="ApiResponse",
 *     type="object",
 *     description= "Entidade de resposta, resultado da resposta usa essa estrutura uniformemente",
 *     title="Retorno padrão",
 *     @Property(property="success", type="boolean", description="Status da resposta"),
 *     @Property(property="code", type="integer", description="Código da resposta"),
 *     @Property(property="message", type="string", description="Mensagem da resposta")
 * )
 *
 * @Schema(
 *     schema="ApiDelete",
 *     type="object",
 *     description= "Entidade de resposta, resultado da resposta usa essa estrutura uniformemente",
 *     title="Retorno padrão",
 *     @Property(property="success", type="boolean"),
 * )
 *
 * @SecurityScheme(
 *     securityScheme="apiAuth",
 *     type="http",
 *     scheme="bearer",
 *     name="JWT bearer",
 *     description= "Informe o token JWT para endpoits seguros",
 *     bearerFormat="JWT",
 *     in="header"
 * )
 *
 * @package App\Http\Controllers
 */

class Controller extends BaseController
{
    //
}

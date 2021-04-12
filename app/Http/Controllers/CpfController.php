<?php

namespace App\Http\Controllers;

use App\Services\CpfService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CpfResource;
use App\Exceptions\ServiceException;
use App\Http\Requests\Cpf\CpfStoreRequest;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\Delete;
use OpenApi\Annotations\Schema;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\RequestBody;

class CpfController extends Controller
{
    /**
     * CpfController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @Get(
     *     path="/cpf",
     *     tags={"CPFs"},
     *     summary="Lista de CPFs.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="paged",
     *         in="query",
     *         description="Paginado",
     *         required=false,
     *         example="false",
     *         @Schema(type="boolean")
     *     ),
     *     @Parameter(
     *         name="showUser",
     *         in="query",
     *         description="Exibir Usuário",
     *         required=false,
     *         example="false",
     *         @Schema(type="boolean")
     *     ),
     *     @Parameter(
     *         name="showRole",
     *         in="query",
     *         description="Exibir os Perfis do Usuário",
     *         required=false,
     *         example="false",
     *         @Schema(type="boolean")
     *     ),
     *     @Parameter(
     *         name="showPermission",
     *         in="query",
     *         description="Exibir as Permissões do Perfil do Usuário",
     *         required=false,
     *         example="false",
     *         @Schema(type="boolean")
     *     ),
     *     @Response(
     *         response="200",
     *         description="Resposta Operacional Normal",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/CpfsPaginateResponse")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return (new CpfService())->findAll($request);
    }

    /**
     * @Post(
     *     path="/cpf",
     *     tags={"CPFs"},
     *     summary="Criar novo CPF.",
     *     security={{ "apiAuth": {} }},
     *     @RequestBody(
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 required={"cpf"},
     *                 @Property(property="cpf", type="string", description="Informe o CPF")
     *             )
     *         )
     *     ),
     *     @Response(
     *         response="200",
     *         description="Resposta Operacional Normal",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/CpfContent")
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param CpfStoreRequest $request
     * @return CpfResource
     * @throws ServiceException
     */
    public function store(CpfStoreRequest $request): CpfResource
    {
        return (new CpfService())->addCpf($request);
    }

    /**
     * @Get(
     *     path="/cpf/{cpf}",
     *     tags={"CPFs"},
     *     summary="Checar CPF.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="cpf",
     *         in="path",
     *         description="Informe o CPF",
     *         required=true,
     *         @Schema(type="string")
     *     ),
     *     @Parameter(
     *         name="showUser",
     *         in="query",
     *         description="Exibir Usuário",
     *         required=false,
     *         example="false",
     *         @Schema(type="boolean")
     *     ),
     *     @Parameter(
     *         name="showRole",
     *         in="query",
     *         description="Exibir os Perfis do Usuário",
     *         required=false,
     *         example="false",
     *         @Schema(type="boolean")
     *     ),
     *     @Parameter(
     *         name="showPermission",
     *         in="query",
     *         description="Exibir as Permissões do Perfil do Usuário",
     *         required=false,
     *         example="false",
     *         @Schema(type="boolean")
     *     ),
     *     @Response(
     *         response="200",
     *         description="Resposta Operacional Normal",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/CpfContent")
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param string $cpf
     * @return CpfResource
     * @throws ServiceException
     */
    public function show(string $cpf): CpfResource
    {
        return (new CpfService())->checkCpf($cpf);
    }

    /**
     * @Delete(
     *     path="/cpf/{cpf}",
     *     tags={"CPFs"},
     *     summary="Remover CPF.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="cpf",
     *         in="path",
     *         description="Informe o CPF",
     *         required=true,
     *         @Schema(type="string")
     *     ),
     *     @Response(
     *         response="200",
     *         description="Resposta Operacional Normal",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiDelete")
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param string $cpf
     * @return JsonResponse
     * @throws ServiceException
     */
    public function destroy(string $cpf): JsonResponse
    {
        return (new CpfService())->removeCpf($cpf);
    }
}

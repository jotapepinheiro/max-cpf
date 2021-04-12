<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Put;
use App\Services\RoleService;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\Items;
use OpenApi\Annotations\Delete;
use OpenApi\Annotations\Schema;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Parameter;
use App\Services\PermissionService;
use App\Exceptions\ServiceException;
use App\Http\Resources\RoleResource;
use OpenApi\Annotations\RequestBody;
use App\Http\Resources\RoleCollection;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;

class RoleController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    /**
     * @Get(
     *     path="/roles",
     *     tags={"Roles"},
     *     summary="Lista de perfis.",
     *     security={{ "apiAuth": {} }},
     *     @Response(
     *         response="200",
     *         description="Resposta Operacional Normal",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/RolesPaginateResponse")
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
     * @return RoleCollection
     */
    public function index(Request $request): RoleCollection
    {
        return (new RoleService())->findAll($request);
    }

    /**
     * Mostre o formulário para criar um novo perfil.
     *
     * @return mixed
     */
    public function create()
    {
        return (new PermissionService())->findAll();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @throws ServiceException
     */
    public function edit(int $id): JsonResponse
    {
        return (new RoleService())->editRole($id);
    }

    /**
     * @Post(
     *     path="/roles",
     *     tags={"Roles"},
     *     summary="Criar novo perfil.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="permissions[]",
     *         in="query",
     *         description="Permissões do Perfil",
     *         required=true,
     *         @Schema(type="array", @Items(type="integer"))
     *     ),
     *     @RequestBody(
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 required={"name", "display_name", "description"},
     *                 @Property(property="name", type="string", description="Nome do Perfil"),
     *                 @Property(property="display_name", type="string", description="Nome de Exibição"),
     *                 @Property(property="description", type="string", description="Descrição")
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
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/RoleContent")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param RoleStoreRequest $request
     * @return RoleResource
     * @throws ServiceException
     */
    public function store(RoleStoreRequest $request): RoleResource
    {
        return (new RoleService())->addRole($request);
    }

    /**
     * @Get(
     *     path="/roles/{id}",
     *     tags={"Roles"},
     *     summary="Listar perfil por ID.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do Perfil",
     *         required=true,
     *         @Schema(type="integer")
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
     *                         @Property(property="data", ref="#/components/schemas/RoleContent")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param $id
     * @return RoleResource
     * @throws ServiceException
     */
    public function show($id): RoleResource
    {
        return (new RoleService())->showRole($id);
    }

    /**
     * @Put(
     *     path="/roles/{id}",
     *     tags={"Roles"},
     *     summary="Atualizar perfil.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do Perfil",
     *         required=true,
     *         @Schema(type="integer")
     *     ),
     *     @Parameter(
     *         name="permissions[]",
     *         in="query",
     *         description="Permissões do Perfil",
     *         required=true,
     *         @Schema(type="array", @Items(type="integer"))
     *     ),
     *     @RequestBody(
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 required={"display_name", "description"},
     *                 @Property(property="display_name", type="string", description="Nome de Exibição"),
     *                 @Property(property="description", type="string", description="Descrição")
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
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/RoleContent")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param int $id
     * @param RoleUpdateRequest $request
     * @return RoleResource
     * @throws ServiceException
     */
    public function update(RoleUpdateRequest $request, int $id): RoleResource
    {
        return (new RoleService())->updateRole($request, $id);
    }

    /**
     * @Delete(
     *     path="/roles/{id}",
     *     tags={"Roles"},
     *     summary="Deletar perfil e permissões em cascata.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do Perfil",
     *         required=true,
     *         @Schema(type="integer")
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
     * @param int $id
     * @return JsonResponse
     * @throws ServiceException
     */
    public function destroy(int $id): JsonResponse
    {
        return (new RoleService())->removeRole($id);
    }

}

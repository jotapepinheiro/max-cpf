<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations\Put;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\Delete;
use OpenApi\Annotations\Schema;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\MediaType;
use App\Services\PermissionService;
use App\Exceptions\ServiceException;
use OpenApi\Annotations\RequestBody;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\PermissionCollection;
use App\Http\Requests\Permission\PermissionStoreRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;

class PermissionController extends Controller
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
     *     path="/permissions",
     *     tags={"Permissions"},
     *     summary="Lista de permissões.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="paged",
     *         in="query",
     *         description="Paginado",
     *         required=false,
     *         example="true",
     *         @Schema(type="boolean")
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
     *                         @Property(property="data", ref="#/components/schemas/PermissionsPaginateResponse")
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
     * @return PermissionCollection
     */
    public function index(Request $request): PermissionCollection
    {
        return (new PermissionService())->findAll($request);
    }

    /**
     * @Post(
     *     path="/permissions",
     *     tags={"Permissions"},
     *     summary="Criar nova permissão.",
     *     security={{ "apiAuth": {} }},
     *     @RequestBody(
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 required={"name", "display_name", "description"},
     *                 @Property(property="name", type="string", description="Nome da Permissão"),
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
     *                     @Schema(ref="#/components/schemas/PermissionContent")
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param PermissionStoreRequest $request
     * @return PermissionResource
     * @throws ServiceException
     */
    public function store(PermissionStoreRequest $request): PermissionResource
    {
        return (new PermissionService())->addPermission($request->all());
    }

    /**
     * @Get(
     *     path="/permissions/{id}",
     *     tags={"Permissions"},
     *     summary="Listar permissão por ID.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="id",
     *         in="path",
     *         description="Id da Permissão",
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
     *                         @Property(property="data", ref="#/components/schemas/PermissionContent")
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
     * @return PermissionResource
     * @throws ServiceException
     */
    public function show($id): PermissionResource
    {
        return (new PermissionService())->showPermission($id);
    }

    /**
     * @Put(
     *     path="/permissions/{id}",
     *     tags={"Permissions"},
     *     summary="Atualizar permissão.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="id",
     *         in="path",
     *         description="Id da Permissão",
     *         required=true,
     *         @Schema(type="integer")
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
     *                         @Property(property="data", ref="#/components/schemas/PermissionContent")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param PermissionUpdateRequest $request
     * @param int $id
     * @return PermissionResource
     * @throws ServiceException
     */
    public function update(PermissionUpdateRequest $request, int $id): PermissionResource
    {
        return (new PermissionService())->updatePermission($request, $id);
    }

    /**
     * @Delete(
     *     path="/permissions/{id}",
     *     tags={"Permissions"},
     *     summary="Deletar permissão.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="id",
     *         in="path",
     *         description="Id da Permissão",
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
        return (new PermissionService())->removePermission($id);
    }
}

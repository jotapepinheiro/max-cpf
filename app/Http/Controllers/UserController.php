<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Put;
use App\Services\UserService;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\Items;
use OpenApi\Annotations\Delete;
use OpenApi\Annotations\Schema;
use OpenApi\Annotations\Property;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Parameter;
use App\Exceptions\ServiceException;
use App\Http\Resources\UserResource;
use OpenApi\Annotations\RequestBody;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserRegisterRequest;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register']]);
    }

    /**
     * @Get(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Lista de usuários.",
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
     *                         @Property(property="data", ref="#/components/schemas/UsersPaginateResponse")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return (new UserService())->findAll($request);
    }

    /**
     * @Post(
     *     path="/auth/register",
     *     tags={"Login"},
     *     summary="Registrar uma nova conta no sistema.",
     *     @RequestBody(
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 required={"name", "email", "password", "password_confirmation"},
     *                 @Property(property="name", type="string", description="Nome"),
     *                 @Property(property="email", type="string", description="E-mail"),
     *                 @Property(property="password", type="string", description="Senha"),
     *                 @Property(property="password_confirmation", type="string", description="Confirmar Senha")
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
     *                         @Property(property="data", ref="#/components/schemas/UserContent")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param UserRegisterRequest $request
     * @return UserResource
     * @throws ServiceException
     */
    public function register(UserRegisterRequest $request): UserResource
    {
        return (new UserService())->registerUser($request);
    }

    /**
     * @Get(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Listar usuário por ID.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do Usuário",
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
     *                         @Property(property="data", ref="#/components/schemas/UserContent")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     *
     * @param $id
     * @return UserResource
     * @throws ServiceException
     */
    public function show($id): UserResource
    {
        return (new UserService())->showUser($id);
    }

    /**
     * @Post(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Cadastrar usuário.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="roles[]",
     *         in="query",
     *         description="Perfis do Usuário",
     *         required=true,
     *         @Schema(type="array", @Items(type="integer"))
     *     ),
     *     @RequestBody(
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 required={"name", "email", "password", "password_confirmation"},
     *                 @Property(property="name", type="string", description="Nome"),
     *                 @Property(property="email", type="string", description="E-mail"),
     *                 @Property(property="password", type="string", description="Senha"),
     *                 @Property(property="password_confirmation", type="string", description="Confirmar Senha")
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
     *                         @Property(property="data", ref="#/components/schemas/UserContent")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param UserStoreRequest $request
     * @return UserResource
     * @throws ServiceException
     */
    public function store(UserStoreRequest $request): UserResource
    {
        return (new UserService())->addUser($request);
    }

    /**
     * @Put(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Atualizar usuário.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do Usuário",
     *         required=true,
     *         @Schema(type="integer")
     *     ),
     *     @Parameter(
     *         name="roles[]",
     *         in="query",
     *         description="Perfis do Usuário",
     *         required=true,
     *         @Schema(type="array", @Items(type="integer"))
     *     ),
     *     @RequestBody(
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 required={"name", "email"},
     *                 @Property(property="name", type="string", description="Nome do Usuário"),
     *                 @Property(property="email", type="string", description="E-mail do Usuário")
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
     *                         @Property(property="data", ref="#/components/schemas/UserContent")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param UserUpdateRequest $request
     * @param int $id
     * @return UserResource
     * @throws ServiceException
     */
    public function update(UserUpdateRequest $request, int $id): UserResource
    {
        return (new UserService())->updateUser($request, $id);
    }

    /**
     * @Delete(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Deletar usuário.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do Usuário",
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
        return (new UserService())->removeUser($id);
    }
}

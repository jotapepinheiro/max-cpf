<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\Schema;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\MediaType;
use App\Http\Requests\Auth\AuthLoginRequest;

class AuthController extends Controller
{

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @Post(
     *     path="/auth/login",
     *     tags={"Login"},
     *     summary="Logar no sistema JWT por meio de e-mail e senha.",
     *     @Parameter(
     *         name="email",
     *         in="query",
     *         description="E-mail",
     *         required=true,
     *         example="admin@admin.com",
     *         @Schema(type="string")
     *     ),
     *     @Parameter(
     *         name="password",
     *         in="query",
     *         description="Senha",
     *         required=true,
     *         example="admin",
     *         @Schema(type="string")
     *     ),
     *     @Parameter(
     *         name="remember",
     *         in="query",
     *         description="Lembre-me",
     *         required=false,
     *         example="true",
     *         @Schema(type="boolean")
     *     ),
     *     @Response(
     *         response="200",
     *         description= "Normal Response",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/LoginProperty")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     *
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        return (new AuthService())->login($request);
    }

    /**
     * @Get(
     *     path="/auth/me",
     *     tags={"Auth"},
     *     summary="Retorna os dados do usuário logado.",
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
     *                         @Property(property="data", ref="#/components/schemas/MeResponse")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return (new AuthService())->me();
    }

    /**
     * @Get(
     *     path="/auth/payoad",
     *     tags={"Auth"},
     *     summary="Retorna dados de payload JWT.",
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
     *                         @Property(property="data", ref="#/components/schemas/PayloadResponse")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @return JsonResponse
     */
    public function payoad(): JsonResponse
    {
        return (new AuthService())->payoad();
    }

    /**
     * @Post(
     *     path="/auth/logout",
     *     tags={"Auth"},
     *     summary="Desconecte o usuário (invalide o token).",
     *     security={{ "apiAuth": {} }},
     *     @Response(
     *         response="200",
     *         description="Resposta Operacional Normal",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse")
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return (new AuthService())->logout();
    }

    /**
     * @Post(
     *     path="/auth/refresh",
     *     tags={"Auth"},
     *     summary="Renova o Token.",
     *     security={{ "apiAuth": {} }},
     *     @Response(
     *         response="200",
     *         description="Resposta Operacional Normal",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse")
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return (new AuthService())->refresh();
    }
}

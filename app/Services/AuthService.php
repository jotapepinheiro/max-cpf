<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * @param $request
     * @return JsonResponse
     */
    public function login($request): JsonResponse
    {
        $input = $request->only('email', 'password');

        if($request->input('remember')) {
            $token_ttl = config('jwt.remember_me');
            Auth::factory()->setTTL($token_ttl * 10080);
        }

        if (! $token = Auth::attempt($input)) {
            return response()->json(['success' => false, 'code' => 401, 'message' => 'Usuário não autorizado.'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $user = Auth::user()->load('roles.permissions');

        return response()->json(['success' => true, 'code' => 200, 'data' => $user], 200);
    }

    /**
     * @return JsonResponse
     */
    public function payoad(): JsonResponse
    {
        $payload = Auth::payload();

        $dates = [
            'emitido_em' => Carbon::createFromTimestamp($payload('iat'))->format('d-m-Y H:i:s'),
            'expira_em' => Carbon::createFromTimestamp($payload('exp'))->format('d-m-Y H:i:s'),
            'nao_antes_de' => Carbon::createFromTimestamp($payload('nbf'))->format('d-m-Y H:i:s')
        ];

        return response()->json(['success' => true, 'code' => 200, 'data' => ['payload' => $payload, 'datas' => $dates]] , 200);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json(['success' => true, 'code' => 200, 'message' => 'Deslogado com Sucesso!!'], 200);
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        try {
            $newToken = Auth::refresh();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return $this->respondWithToken($newToken);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        $ttl = (int) Auth::factory()->getTTL();

        return response()->json(['success' => true, 'code' => 200, 'data' => [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in_minutes' => $ttl,
            'expires_in_date' => Carbon::now()->addMinute($ttl)->format('d-m-Y H:i:s'),
        ]], 200);
    }

}

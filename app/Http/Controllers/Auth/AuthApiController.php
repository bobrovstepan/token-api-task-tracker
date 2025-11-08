<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthApiService;

class AuthApiController extends Controller
{
    public function __construct(
        private AuthApiService $authApiService
    ){}

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $token = $this->authApiService->generateAndGetToken($request->validated());

            return response()->json([
                'success' => true,
                'token' => $token,
            ], 200);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 401);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Auth\AuthService;
use App\Traits\ResponseTrait;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = $this->authService->register($validated);

        return ApiResponse::success([
            'message' => 'Register successfully',
            'user' => UserResource::make($user),
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->login($request->email, $request->password);

        if (!$user) {
            return ApiResponse::error(['error' => 'Unauthorized'], 401);
        }

        $token = $this->authService->generateToken($user);

        return ApiResponse::success([
            'message' => 'Login successfully',
            'token' => $token,
            'user' => UserResource::make($user),
        ]);
    }

    public function logout()
    {
        $this->authService->logout(auth()->user());
        return ApiResponse::success(['message' => 'Logged out successfully']);
    }
}

<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Http\Requests\Auth\UpdateProfileRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

     public function register(RegisterRequest $request): JsonResponse
     {
        $result = $this->authService->register($request->toDTO());
        return response()->json($result, 201);
    }


    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->toDTO());
        return response()->json($result);
    }

     public function logout(Request $request): JsonResponse
     {
        $this->authService->logout(Auth::id());
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function profile()
    {
        return response()->json([
            'status' => 'success',
            'data' => Auth::user()
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $this->authService->updateProfile(Auth::id(), $request->toDTO());

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }
}

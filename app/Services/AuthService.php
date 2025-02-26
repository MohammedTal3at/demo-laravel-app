<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): array
    {
        $user = $this->userRepository->create($data);
        $token = $this->userRepository->createToken($user, 'auth_token');

        return ['token' => $token];
    }

    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();
        $token = $this->userRepository->createToken($user, 'auth_token');

        return ['token' => $token];
    }

    public function logout(int $userId): void
    {
        $user = $this->userRepository->findById($userId);
        $this->userRepository->deleteTokens($user);
    }

    public function updateProfile(int $userId, array $data): User
    {
        $user = $this->userRepository->findById($userId);
        return $this->userRepository->update($user, $data);
    }
} 
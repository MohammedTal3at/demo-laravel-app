<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Auth\LoginDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\DTOs\Auth\UpdateProfileDTO;

class AuthService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterDTO $dto): array
    {
        $user = $this->userRepository->create($dto->toArray());
        $token = $this->userRepository->createToken($user, 'auth_token');

        return ['token' => $token];
    }

    public function login(LoginDTO $dto): array
    {
        if (!Auth::attempt($dto->toArray())) {
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

    public function updateProfile(int $userId, UpdateProfileDTO $dto): User
    {
        $user = $this->userRepository->findById($userId);
        
        $data = array_filter($dto->toArray(), fn($value) => !is_null($value));
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($user, $data);
    }
} 
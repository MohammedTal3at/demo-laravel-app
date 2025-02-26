<?php

namespace App\Contracts\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function findByEmail(string $email): ?User;
    public function update(User $user, array $data): User;
    public function createToken(User $user, string $name): string;
    public function deleteTokens(User $user): void;
} 
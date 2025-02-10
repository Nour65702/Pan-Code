<?php

namespace App\Services\Auth;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function register(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function login(string $email, string $password)
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return null;
    }


    public function generateToken($user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logout($user)
    {
        $user->tokens()->delete();
    }
}

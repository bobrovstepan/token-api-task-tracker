<?php

namespace App\Services\Auth;

class AuthApiService
{
    public function generateAndGetToken(array $input): string
    {
        if (!auth()->attempt($input)) {
            throw new \Exception('Invalid credentials');
        }

        return auth()->user()->createToken('api')->plainTextToken;
    }
}

<?php

namespace AppModules\User\Application\Services;

use AppModules\User\Domain\Entities\User;
use AppModules\User\Infrastructure\Persistence\Models\UserModel;

class AuthService
{
    public function generateToken(User $user): string
    {
        $userModel = UserModel::where('email', $user->getEmail())->firstOrFail();

        return $userModel->createToken('api_token')->plainTextToken;
    }
}

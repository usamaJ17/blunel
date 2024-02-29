<?php

namespace App\Services;

class PasswordResetService
{
    public function getAddData(object $vendor, string $token,string $userType):array
    {
        return [
            'identity' => $vendor['email'],
            'token' => $token,
            'user_type'=>$userType,
            'created_at' => now(),
        ];
    }
}

<?php

namespace AppModules\user\Application\DTOs;


//This file Data Transfer To Object (DTO)
class RegisterUserDTO
{
    private string $hashedPassword;

    public function __construct(private string $name, private string $email, private string $password)
    {
        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }
}

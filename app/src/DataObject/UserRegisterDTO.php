<?php

namespace App\DataObject;

use Symfony\Component\Validator\Constraints as Assert;

class UserRegisterDTO
{

    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        private readonly string $email,
        #[Assert\NotBlank]
        private readonly string $password
    )
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}
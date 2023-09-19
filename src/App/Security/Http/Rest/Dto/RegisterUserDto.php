<?php

declare(strict_types=1);

namespace App\Security\Http\Rest\Dto;

use Security\Domain\ValueObject\AllowedRoles;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserDto
{
    #[Assert\NotBlank]
    private string $username;

    #[Assert\NotBlank]
    private string $password;

    #[Assert\Email]
    #[Assert\NotBlank]
    private string $email;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [AllowedRoles::class, 'getAllowedRoles'], multiple: true)]
    private array $roles;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): RegisterUserDto
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): RegisterUserDto
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): RegisterUserDto
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): RegisterUserDto
    {
        $this->roles = $roles;

        return $this;
    }
}

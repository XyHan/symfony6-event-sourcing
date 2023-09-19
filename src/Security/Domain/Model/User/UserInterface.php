<?php

namespace Security\Domain\Model\User;

interface UserInterface
{
    public function getUuid(): string;

    public function setUuid(string $uuid): UserInterface;

    public function getUsername(): string;

    public function setUsername(string $username): UserInterface;

    public function getEmail(): string;

    public function setEmail(string $email): UserInterface;

    public function getRoles(): array;

    public function setRoles(array $roles): UserInterface;

    public function getPassword(): ?string;

    public function setPassword(?string $password): UserInterface;
}

<?php

namespace Admin\Project\Auth\Interface;

interface UserManagerInterface
{
    public function getUserToken(): ?UserTokenInterface;

    public function hasUserToken(): bool;

    public function logout(): void;

    public function cryptPassword(string $plainPassword): string;

    public function isPasswordValid(UserInterface $user, string $plainPassword): bool;
}

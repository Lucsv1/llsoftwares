<?php

namespace Admin\Project\Auth\Interface;

interface UserInterface
{
    public function getUsername(): ?string;

    public function getPassword(): ?string;

    public function getRoles(): array;

    public function isEnabled(): bool;
}

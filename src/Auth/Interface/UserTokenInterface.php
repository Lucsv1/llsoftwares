<?php

namespace Admin\Project\Auth\Interface;

interface UserTokenInterface
{
    const DEFAULT_PREFIX_KEY = 'user_security';

    public function getUser(): UserInterface;

    public function serialize(): string;
}

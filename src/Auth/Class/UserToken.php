<?php

namespace Admin\Project\Auth\Class;

use Admin\Project\Auth\Interface\UserInterface;
use Admin\Project\Auth\Interface\UserTokenInterface;

class UserToken implements UserTokenInterface
{
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function serialize(): string
    {
        return serialize($this);
    }
}

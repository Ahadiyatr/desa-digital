<?php

namespace App\Interface;

interface AuthRepositoryInterface
{
    public function login(array $data);
    public function logout();
    public function me();
}

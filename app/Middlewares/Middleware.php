<?php

namespace App\Middlewares;

use App\Models\User;

interface Middleware
{
    public function handle(array $vars): void;
}
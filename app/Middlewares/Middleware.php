<?php

namespace App\Middlewares;

interface Middleware
{
    public function handle(array $vars): void;
}
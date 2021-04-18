<?php

namespace App\Middlewares;


class AuthMiddleware implements Middleware
{
    public function handle(array $vars): void
    {
        if($_SESSION['authId'] != $vars['id']){
            header('Location:/');
        };
    }
}
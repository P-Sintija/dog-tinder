<?php

namespace App\ Controllers;

use App\Services\LookService;
use Twig\Environment;

class LookController
{
    private LookService $service;
    private Environment $environment;

    public function __construct(LookService $service, Environment $environment)
    {
        $this->service = $service;
        $this->environment = $environment;
    }

    public function lookingFor(): void
    {
        $user = $this->service->getUser('id', $_GET['id']);
        $interest = $this->service->getInterest($user);
        echo '<pre>';
        var_dump($interest);





    }

}
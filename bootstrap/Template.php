<?php

use Twig\Environment;

class Template
{
    private Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function view(string $path, array $content): string
    {
        return $this->environment->render($path, $content);
    }
}
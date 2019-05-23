<?php declare(strict_types=1);

namespace App\UI\Controller;

use Symfony\Component\HttpFoundation\Response;

class HealthCheckController
{
    public function execute(): Response
    {
        return new Response();
    }
}

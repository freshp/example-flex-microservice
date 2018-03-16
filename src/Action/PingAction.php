<?php
declare(strict_types=1);

namespace App\Action;

use Symfony\Component\HttpFoundation\JsonResponse;

class PingAction
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse();
    }
}

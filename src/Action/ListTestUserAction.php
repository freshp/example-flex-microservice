<?php
declare(strict_types=1);

namespace App\Action;

use App\Repository\TestUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListTestUserAction
{
    private $testUserRepository;

    public function __construct(TestUserRepository $testUserRepository)
    {
        $this->testUserRepository = $testUserRepository;
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->testUserRepository->findAll());
    }
}

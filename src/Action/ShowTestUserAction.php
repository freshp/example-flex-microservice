<?php
declare(strict_types=1);

namespace App\Action;

use App\Repository\TestUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowTestUserAction
{
    private $testUserRepository;

    public function __construct(TestUserRepository $testUserRepository)
    {
        $this->testUserRepository = $testUserRepository;
    }

    public function __invoke(int $testUserId): JsonResponse
    {
        $user = $this->testUserRepository->findOneBy(['identifier' => $testUserId]);

        return new JsonResponse($user);
    }
}

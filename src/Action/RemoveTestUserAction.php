<?php
declare(strict_types=1);

namespace App\Action;

use App\Entity\TestUser;
use App\Repository\TestUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class RemoveTestUserAction
{
    private $testUserRepository;

    public function __construct(TestUserRepository $testUserRepository)
    {
        $this->testUserRepository = $testUserRepository;
    }

    public function __invoke(int $testUserId): JsonResponse
    {
        /** @var TestUser $user */
        $user = $this->testUserRepository->findOneBy(['identifier' => $testUserId]);
        if (false === $user instanceof TestUser) {
            return new JsonResponse('', 400);
        }

        $this->testUserRepository->remove($user);

        return new JsonResponse(true);
    }
}

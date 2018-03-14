<?php
declare(strict_types=1);

namespace App\Action;

use App\Entity\TestUser;
use App\Repository\TestUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddTestUserAction
{
    private $testUserRepository;

    public function __construct(TestUserRepository $testUserRepository)
    {
        $this->testUserRepository = $testUserRepository;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $user = new TestUser($request->get('name'));
        $user->setCreatedBy(1);
        $user->setUpdatedBy(1);

        $this->testUserRepository->persist($user);

        return new JsonResponse($user);
    }
}

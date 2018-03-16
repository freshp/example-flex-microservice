<?php
declare(strict_types=1);

namespace App\Action;

use App\Entity\TestUser;
use App\Repository\TestUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateTestUserAction
{
    private $testUserRepository;

    public function __construct(TestUserRepository $testUserRepository)
    {
        $this->testUserRepository = $testUserRepository;
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var TestUser $user */
        $user = $this->testUserRepository->findOneBy(['identifier' => $request->get('id')]);

        if (false === $user instanceof TestUser) {
            return new JsonResponse('', 400);
        }

        $user->setName($request->get('name'));
        // TODO: get user data by request for example
        $user->setUpdatedBy(2);
        $this->testUserRepository->persist($user);

        return new JsonResponse($user);
    }
}

<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\TestUser;
use Doctrine\ORM\EntityRepository;
use Gedmo\SoftDeleteable\SoftDeleteableListener;

class TestUserRepository extends EntityRepository
{
    public function persist(TestUser $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function remove(TestUser $user)
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush($user);
    }

    /**
     * method to hard delete by remove event listener and readd after deletion
     */
    public function hardDelete(TestUser $user)
    {
        $originalEventListeners = [];
        $entityManager = $this->getEntityManager();
        $eventManager = $entityManager->getEventManager();

        foreach ($eventManager->getListeners() as $eventName => $listeners) {
            foreach ($listeners as $listener) {
                if (false === $listener instanceof SoftDeleteableListener) {
                    continue;
                }

                $originalEventListeners[$eventName] = $listener;
                $eventManager->removeEventListener($eventName, $listener);
            }
        }

        $entityManager->remove($user);
        $entityManager->flush($user);

        foreach ($originalEventListeners as $eventName => $listener) {
            $eventManager->addEventListener($eventName, $listener);
        }
    }

    public function findOldSoftdeletedEntries(\DateTime $hardDeleteDate): array
    {
        // filters will be disabled just to find the entries
        $this->getEntityManager()->getFilters()->disable('softdeleteable');
        $entries = $this->createQueryBuilder('tu')
            ->where('tu.deletedAt < :hardDeleteTime')
            ->andWhere('tu.deletedAt IS NOT NULL')
            ->setParameter('hardDeleteTime', $hardDeleteDate)
            ->getQuery()
            ->getResult();
        $this->getEntityManager()->getFilters()->enable('softdeleteable');

        return $entries;
    }
}

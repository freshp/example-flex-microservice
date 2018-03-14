<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="test_user")
 * @ORM\Entity(repositoryClass="App\Repository\TestUserRepository")
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", hardDelete=false)
 */
class TestUser implements \JsonSerializable
{
    use TimestampableEntity;
    use BlameableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $identifier;

    /**
     * @ORM\Column(type="string", name="name")
     * @Gedmo\Versioned
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getIdentifier(): int
    {
        return $this->identifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function jsonSerialize()
    {
        return [
            'identifier' => $this->getIdentifier(),
            'name' => $this->getName(),
            'crdate' => $this->getCreatedAt(),
            'creator' => $this->getCreatedBy(),
            'update' => $this->getUpdatedAt(),
            'updator' => $this->getUpdatedBy(),
            'deleted' => $this->isDeleted(),
        ];
    }
}

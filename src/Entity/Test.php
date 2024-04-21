<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TestRepository;
use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TestRepository::class)]
#[ORM\Table(name: 'test')]
#[ORM\HasLifecycleCallbacks]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime', nullable: false)]
    #[Assert\NotNull]
    private ?DateTime $started = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $finished = null;

    #[ORM\OneToMany(targetEntity: TestData::class, mappedBy: 'test')]
    private Collection $testData;

    public function __construct()
    {
        $this->testData = new ArrayCollection();
        $this->results = json_encode([]);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFinished(): ?DateTime
    {
        return $this->finished;
    }

    public function setFinished(): self
    {
        $this->finished = new DateTime('now', new DateTimeZone('UTC'));
        return $this;
    }

    public function getStarted(): ?DateTime
    {
        return $this->started;
    }

    public function getTestData(): Collection
    {
        return $this->testData;
    }

    #[ORM\PrePersist]
    public function setStarted(): void
    {
        $this->started = new DateTime('now', new DateTimeZone('UTC'));
    }
}

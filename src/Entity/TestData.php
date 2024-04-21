<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TestDataRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TestDataRepository::class)]
#[ORM\Table(name: 'test_data')]
class TestData
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Test::class, inversedBy: 'test_data')]
    private Test $test;

    #[ORM\ManyToOne(targetEntity: Question::class, fetch: 'EXTRA_LAZY', inversedBy: 'test_data')]
    private Question $question;

    #[ORM\Column(type: 'integer', nullable: false)]
    #[Assert\NotNull]
    private ?int $orderId = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $answers = null;

    #[ORM\Column(type: 'boolean', nullable: false)]
    private bool $isValid = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTest(Test $test): self
    {
        $this->test = $test;
        return $this;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;
        return $this;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(?int $orderId): self
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getAnswers(): array
    {
        return json_decode($this->answers ?? '[]', true);
    }

    public function setAnswers(array $answers): self
    {
        $this->answers = json_encode($answers);
        return $this;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;
        return $this;
    }
}

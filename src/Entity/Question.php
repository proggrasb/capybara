<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\Table(name: 'question')]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    #[Assert\NotNull]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 128)]
    private ?string $question = null;

    #[ORM\Column(type: 'boolean', nullable: false)]
    private bool $isActive = true;

    #[ORM\OneToMany(targetEntity: Answer::class, mappedBy: 'question')]
    private Collection $answers;

    private bool $sValid = false;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;
        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function isValid(): bool
    {
        return $this->sValid;
    }

    public function setValid(bool $sValid): self
    {
        $this->sValid = $sValid;
        return $this;
    }
}

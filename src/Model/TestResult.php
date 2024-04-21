<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Question;

class TestResult
{
    /**
     * @var array|Question[]
     */
    private array $validQuestions = [];

    /**
     * @var array|Question[]
     */
    private array $invalidQuestions = [];

    public function __construct(
        private readonly int $testId
    )
    {}

    public function getTestId(): int
    {
        return $this->testId;
    }

    public function getValidQuestions(): array
    {
        return $this->validQuestions;
    }

    public function getInvalidQuestions(): array
    {
        return $this->invalidQuestions;
    }

    public function addValidQuestion(Question $question): self
    {
        $this->validQuestions[] = $question;
        return $this;
    }

    public function addInvalidQuestion(Question $question): self
    {
        $this->invalidQuestions[] = $question;
        return $this;
    }
}

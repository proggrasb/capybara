<?php

declare(strict_types=1);

namespace App\Model;

class TestInfo
{
    public function __construct(
        private readonly int $id,
        private readonly array $questions
    )
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }
}

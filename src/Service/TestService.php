<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Test;
use App\Entity\TestData;
use App\Model\TestInfo;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class TestService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {}

    public function requestQuestions(int $count): TestInfo
    {
        $questions = $this->entityManager->getRepository(Question::class)->getRandomQuestions($count);
        $test = new Test();
        $this->entityManager->persist($test);

        $order = 0;
        /** @var Question $question */
        foreach ($questions as $question) {
            $testData = (new TestData())
                ->setTest($test)
                ->setQuestion($question)
                ->setOrderId($order++);
            $this->entityManager->persist($testData);
        }

        $this->entityManager->flush();

        return new TestInfo($test->getId(), $questions);
    }

    /**
     * @param int $testId
     * @param array $resultQuestions
     * @return void
     * @throws Exception
     */
    public function checkTest(int $testId, array $resultQuestions): void
    {
        $test = $this->entityManager->getRepository(Test::class)->find($testId);
        if (! $test instanceof Test) {
            throw new Exception('Test #$id not found');
        }

        $testData = $test->getTestData();
        foreach($testData as $data) {
            $question = $data->getQuestion();
            $resultAnswers = $resultQuestions[$question->getId()] ?? [];

            if (empty($resultAnswers)) {
                // if all answers are invalid then this result is valid
                $hasValidAnswers = false;
                /** @var Answer $answer */
                foreach($question->getAnswers() as $answer) {
                    if ($answer->isValid()) {
                        $hasValidAnswers = true;
                        break;
                    }
                }

                $data->setAnswers([]);
                if (!$hasValidAnswers) {
                    $data->setIsValid(true);
                }
                $this->entityManager->persist($data);

                continue;
            }

            $answersIds = [];
            $hasInvalidAnswers = false;

            /** @var Answer $answer */
            foreach ($question->getAnswers() as $answer) {
                if (in_array($answer->getId(), $resultAnswers)) {
                    if (!$answer->isValid()) {
                        $hasInvalidAnswers = true;
                    }
                    $answersIds[] = $answer->getId();
                }
            }

            $data->setAnswers($answersIds)->setIsValid(!$hasInvalidAnswers);
            $this->entityManager->persist($data);
        }

        $test->setFinished();
        $this->entityManager->persist($test);

        $this->entityManager->flush();
    }

    /**
     * @param int $testId
     * @return array
     * @throws Exception
     */
    public function getResults(int $testId): array
    {
        $test = $this->entityManager->getRepository(Test::class)->find($testId);
        if (! $test instanceof Test) {
            throw new Exception('Test #$id not found');
        }

        return $test->getTestData()->toArray();
    }
}

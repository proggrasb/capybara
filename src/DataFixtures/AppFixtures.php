<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AppFixtures extends Fixture
{
    private static $data = [
        [
            'question' => '1 + 1 =',
            'answers' => [
                '3' => false,
                '2' => true,
                '0' => false,
            ],
        ], [
            'question' => '2 + 2 =',
            'answers' => [
                '4' => true,
                '3 + 1' => true,
                '10' => false,
            ],
        ], [
            'question' => '3 + 3 =',
            'answers' => [
                '1 + 5' => true,
                '1' => false,
                '6' => true,
                '2 + 4' => true,
            ],
        ], [
            'question' => '4 + 4 =',
            'answers' => [
                '8' => true,
                '4' => false,
                '0' => false,
                '0 + 8' => true,
            ],
        ], [
            'question' => '5 + 5 =',
            'answers' => [
                '6' => false,
                '18' => false,
                '10' => true,
                '9' => false,
                '0' => false,
            ],
        ], [
            'question' => '6 + 6 =',
            'answers' => [
                '3' => false,
                '9' => false,
                '0' => false,
                '12' => true,
                '5 + 7' => true,
            ],
        ], [
            'question' => '7 + 7 =',
            'answers' => [
                '5' => false,
                '14' => true,
            ],
        ], [
            'question' => '8 + 8 =',
            'answers' => [
                '16' => true,
                '12' => false,
                '9' => false,
                '5' => false,
            ],
        ], [
            'question' => '9 + 9 =',
            'answers' => [
                '18' => true,
                '9' => false,
                '17 + 1' => true,
                '2 + 16' => true,
            ],
        ], [
            'question' => '10 + 10 =',
            'answers' => [
                '0' => false,
                '2' => false,
                '8' => false,
                '20' => true,
            ],
        ],
    ];

    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    private function dataExists(ObjectManager $manager): bool
    {
        $count = $manager
            ->createQuery('select COUNT(u.id) FROM App\Entity\Question u')
            ->getSingleScalarResult();

        return ($count !== 0);
    }

    public function load(ObjectManager $manager): void
    {
        if ($this->dataExists($manager)) {
            return;
        }

        foreach (self::$data as $item) {
            $question = (new Question())
                ->setQuestion($item['question']);
            $this->validator->validate($question);
            $manager->persist($question);

            foreach ($item['answers'] as $answer => $valid) {
                $answer = (new Answer())
                    ->setQuestion($question)
                    ->setAnswer($answer)
                    ->setValid($valid);
                $this->validator->validate($answer);
                $manager->persist($answer);
            }
        }

        $manager->flush();
    }
}

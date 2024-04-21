<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\TestService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @param TestService $testService
     * @return Response
     */
    #[Route('/test', name: 'get_test', methods: ['GET'])]
    public function getTest(TestService $testService): Response
    {
        $testData = $testService->requestQuestions($this->getParameter('test.count.question'));

        return $this->render('test.html.twig',[
            'testId' => $testData->getId(),
            'questions' => $testData->getQuestions(),
        ]);
    }

    /**
     * @param Request $request
     * @param TestService $testService
     * @return Response
     * @throws Exception
     */
    #[Route('/test-check', name: 'check_test', methods: ['POST'])]
    public function checkTest(Request $request, TestService $testService): Response
    {
        $testId = (int)($request->request->get('id') ?? 0);
        $data = json_decode($request->request->get('data') ?? '{}', true);
        $testService->checkTest($testId, $data);

        return $this->json([
            'success' => true,
            'id' => $testId,
            'data' => $data,
        ]);
    }

    /**
     * @param int $testId
     * @param TestService $testService
     * @return Response
     * @throws Exception
     */
    #[Route('/results/{testId}', name: 'results_test', methods: ['GET'])]
    public function getResults(int $testId, TestService $testService): Response
    {
        $testService->getResults($testId);
        return $this->render('result.html.twig', [
            'results' => $testService->getResults($testId),
        ]);
    }
}

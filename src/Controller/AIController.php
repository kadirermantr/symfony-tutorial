<?php

namespace App\Controller;

use App\Form\AIChatType;
use App\Services\OpenAI\AIServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ai', name: 'ai.')]
class AIController extends AbstractController
{
    public function __construct(
        protected AIServiceInterface $aiService
    ) { }

    #[Route('/', name: 'create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(AIChatType::class);

        $form->handleRequest($request);
        $form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            $prompt = $form->get('prompt')->getData();
            $model = $form->get('model')->getData();

            $response = $this->aiService->ask($prompt, $model);
        }

        return $this->render('ai/index.html.twig', [
            'form' => $form->createView(),
            'response' => $response ?? null,
        ]);
    }
}

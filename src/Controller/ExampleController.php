<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExampleController extends AbstractController
{
    #[Route('/finder', name: 'app_finder')]
    public function finder(): Response
	{
		$finder = new Finder();
		$finder->files()->in(__DIR__ . '/..')
			->name('*.php');

		$files = [];

		foreach ($finder as $file) {
			$files[] = $file->getFilename();
		}

		return $this->render('example/index.html.twig', [
			'files' => $files,
		]);
    }

    #[Route('/dump', name: 'app_dump')]
    public function dump(): JsonResponse
	{
		$var = [
			'a simple string' => "in an array of 5 elements",
			'a float' => 1.0,
			'an integer' => 1,
			'a boolean' => true,
			'an empty array' => [],
		];

		return new JsonResponse(dump($var), Response::HTTP_OK);
    }
}

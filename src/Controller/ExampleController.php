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
    public function index(): JsonResponse
	{
		$finder = new Finder();
		$finder->files()->in(__DIR__ . '/..')
			->name('*.php');

		foreach ($finder as $file) {
			echo $file->getFilename() . "\n";
		}

		return new JsonResponse(null, Response::HTTP_OK);
    }
}

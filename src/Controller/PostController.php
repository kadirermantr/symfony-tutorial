<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/post', name: 'post.')]
class PostController extends AbstractController
{
	public function __construct(
		protected EntityManagerInterface $entityManager,
	) { }

	#[Route('/', name: 'index')]
	public function index(): Response
	{
		$posts = $this->entityManager->getRepository(Post::class)->findAll();

		return $this->render('post/index.html.twig', [
			'posts' => $posts,
		]);
	}

	#[Route('/show/{id}', name: 'show')]
	public function show(int $id): Response
	{
		$post = $this->entityManager->getRepository(Post::class)->find($id);

		if (! $post) {
			throw $this->createNotFoundException('The post does not exist');
		}

		return $this->render('post/show.html.twig', [
			'post' => $post,
		]);
	}

	#[Route('/create', name: 'create')]
	public function create(Request $request, FileUploader $fileUploader): Response
	{
		$post = new Post();

		$form = $this->createForm(PostType::class, $post);

		$form->handleRequest($request);
		$form->getErrors();

		if ($form->isSubmitted() && $form->isValid()) {
			/** @var UploadedFile $file */
			$file = $form->get('attachment')->getData();

			if ($file) {
				$fileName = $fileUploader->uploadFile($file);
				$post->setImage($fileName);
			}

			$this->entityManager->persist($post);
			$this->entityManager->flush();

			$this->addFlash('success', 'Post created');

			return $this->redirect($this->generateUrl('post.index'));
		}

		return $this->render('post/create.html.twig', [
			'form' => $form->createView(),
		]);
	}

	#[Route('/remove/{id}', name: 'remove')]
	public function remove(Post $post): Response
	{
		$this->entityManager->remove($post);
		$this->entityManager->flush();

		$this->addFlash('success', 'Post was removed');

		return $this->redirect($this->generateUrl('post.index'));
	}
}

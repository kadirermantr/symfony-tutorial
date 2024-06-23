<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
	public function __construct(
		protected EntityManagerInterface $entityManager,
	) { }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $hasher): Response
    {
		if ($this->getUser()) {
			return $this->redirectToRoute('app_home');
		}

		$user = new User();

		$form = $this->createForm(UserRegisterType::class, $user);

		$form->handleRequest($request);
		$form->getErrors();

		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();

			$user->setUsername($data->getUsername());
			$user->setPassword($hasher->hashPassword($user, $data->getPassword()));

			$this->entityManager->persist($user);
			$this->entityManager->flush();

			return $this->redirect($this->generateUrl('app_login'));
		}

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

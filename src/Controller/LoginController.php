<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
   // #[Route('/login', name: 'app_login')]
   // public function login(Request $request, UsersRepository $usersRepository): Response
   // {
   //    $form = $this->createForm(LoginType::class);
   //    $form->handleRequest($request);

   //    if ($form->isSubmitted() && $form->isValid()) {
   //       $data = $form->getData();
   //       $user = $usersRepository->findOneBy(['email' => $data['email']]);
   //       if ($user) {
   //          $this->addFlash('success', 'Login successful');
   //       }
   //    }

   //    return $this->render('users/login.html.twig', [
   //       'form' => $form
   //    ]);
   // }


   #[Route('/login', name: 'app_login')]
   public function login(AuthenticationUtils $authenticationUtils): Response
   {
      $error = $authenticationUtils->getLastAuthenticationError();
      $lastUsername = $authenticationUtils->getLastUsername();


      $form = $this->createForm(LoginType::class, ['email' => $lastUsername]);

      return $this->render('users/login.html.twig', [
         'error' => $error,
         'form' => $form
      ]);
   }

   #[Route('/forgot-password', name: 'app_forgot_password')]
   public function forgotPassword(): Response
   {
      // Logique de réinitialisation du mot de passe
      $form = $this->createForm(LoginType::class, [
         'forgot_password_url' => $this->generateUrl('app_forgot_password')
      ]);
      $this->addFlash('info', 'Fonctionnalité de réinitialisation du mot de passe à implémenter.');
      
      return $this->render('users/login.html.twig', [
         'form' => $form
      ]);
   }

   #[Route('/logout', name: 'app_logout')]
   public function logout(): void
   {
      // Symfony intercepts this; leave empty
   }
}
<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\RolesRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/users')]
final class UsersController extends AbstractController
{
    // Afficher tous les users
    #[Route(name: 'app_users_index', methods: ['GET'])]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }
    // Créer un user 
    #[Route('/new', name: 'app_users_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, RolesRepository $rolesRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Password field is unmapped in the form, set it manually
            $password = $form->get('password')->getData();
            $user->setRole($rolesRepository->findOneBy(['title' => 'user']));

            // Set password
            if ($password !== null && $password !== '') {
                $user->setPassword($passwordHasher->hashPassword($user, $password));
            }

            // Upload avatar
            $uploadedFile = $form->get('avatar')->getData();
            $uploadDir = $this->getParameter('kernel.project_dir').'/public/uploads/users';

            // Utilisation de l'extension de base (si possible)
            $originalExt = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);

            // Recherche de l'extension si elle n'a pas été trouvée à l'étape d'avant
            // Dans un premier temps on va obtenir une méthode propre à Symfony
            // Et si même là ça échoue, alors on met l'extension générique "bin" par défault
            if (!$originalExt) {
                $originalExt = $uploadedFile->getClientOriginalExtension()
                    ?: $uploadedFile->guessExtension()
                    ?: 'bin';
            }

            // Nettoyage du nom
            $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $form->get('nickname')->getData());

            // Nom final AVEC extension d’origine (ou celle par défault : "bin")
            $newFilename = $sanitizedName.'.'.$originalExt;

            // Déplacement et sauvegarde du chemin public
            $uploadedFile->move($uploadDir, $newFilename);
            
            $user->setAvatar($newFilename);
            $entityManager->persist($user);
            $entityManager->flush();
            // Retourner sur la page de tous mes Pokémons
            return $this->redirectToRoute('app_users_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);

        }

        return $this->render('users/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    
    // Affichage par ID (user)
    #[Route('/profile/{id}', name: 'app_users_show', methods: ['GET'])]
    public function show(Users $user): Response
    {
        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    // Update user
#[Route('/edit/{id}', name: 'app_users_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Users $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
{
    $form = $this->createForm(UsersType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Update password if provided (unmapped field)
        $password = $form->get('password')->getData();
        if ($password !== null && $password !== '') {
            $user->setPassword($passwordHasher->hashPassword($user, $password));
        }

        // Gestion de l'upload d'avatar
        $uploadedFile = $form->get('avatar')->getData();
        
        if ($uploadedFile) {
            // Supprimer l'ancien avatar s'il existe
            $oldAvatar = $user->getAvatar();
            if ($oldAvatar) {
                $oldAvatarPath = $this->getParameter('kernel.project_dir').'/public/uploads/users/'.$oldAvatar;
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            // Upload du nouveau avatar
            $uploadDir = $this->getParameter('kernel.project_dir').'/public/uploads/users';

            // Utilisation de l'extension de base (si possible)
            $originalExt = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);

            // Recherche de l'extension si elle n'a pas été trouvée à l'étape d'avant
            if (!$originalExt) {
                $originalExt = $uploadedFile->getClientOriginalExtension()
                    ?: $uploadedFile->guessExtension()
                    ?: 'bin';
            }

            // Nettoyage du nom
            $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $user->getNickname());

            // Nom final AVEC extension d'origine (ou celle par défaut : "bin")
            $newFilename = $sanitizedName.'.'.$originalExt;

            // Déplacement et sauvegarde du chemin public
            $uploadedFile->move($uploadDir, $newFilename);
            
            $user->setAvatar($newFilename);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_users_show', ['id' => $user->getId() ], Response::HTTP_SEE_OTHER);
    }

    return $this->render('users/edit.html.twig', [
        'user' => $user,
        'form' => $form,
    ]);
}
    
    // Delete user
    #[Route('/delete/{id}', name: 'app_users_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Repository\TicketsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/users', name: 'app_admin_users')]
    public function displayUsers(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/tickets', name: 'app_admin_tickets')]
    public function displayTickets(TicketsRepository $ticketsRepository): Response
    {
        $tickets = $ticketsRepository->findAll();
        return $this->render('admin/tickets.html.twig', [
            'tickets' => $tickets,
        ]);
    }
}

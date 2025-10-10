<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Images;
use App\Entity\Tickets;
use App\Enum\Stacks;
use App\Enum\Status as StatusEnum;
use App\Enum\Types;
use App\Form\CommentsType;
use App\Form\TicketsType;
use App\Repository\StatusRepository;
use App\Repository\TicketsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/tickets')]
final class TicketsController extends AbstractController
{
    #[Route(name: 'app_tickets_index', methods: ['GET'])]
    public function index(Request $request, TicketsRepository $ticketsRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 15;

        $filters = [
            'type' => $request->query->get('type'),
            'stack' => $request->query->get('stack'),
            'status' => $request->query->get('status'),
            'search' => $request->query->get('search'),
        ];
        
        $paginator = $ticketsRepository->findPaginated($page, $limit, $filters);
        $total = count($paginator);
        $totalPages = ceil($total / $limit);
        
        return $this->render('tickets/index.html.twig', [
            'tickets' => $paginator,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'stacks' => Stacks::cases(),
            'types' => Types::cases(),
            'status' => StatusEnum::cases(),
            'filters' => $filters,
        ]);
    }

    #[Route('/new', name: 'app_tickets_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager, StatusRepository $statusRepo, SluggerInterface $slugger): Response
    {
        
        $ticket = new Tickets();

        // status Open by default
        $openStatus = $statusRepo->findOneBy(['status' => StatusEnum::OPEN]);

        $form = $this->createForm(TicketsType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setUser($this->getUser());
            $ticket->setStatus($openStatus);
            $ticket->setCreatedAt(new \DateTimeImmutable());

            // Gérer l'upload des images
            /** @var UploadedFile[] $imageFiles */
            $imageFiles = $form->get('imageFiles')->getData();

            if ($imageFiles) {
                foreach ($imageFiles as $imageFile) {
                    // Générer un nom de fichier unique
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                    // Déplacer le fichier dans le dossier d'upload
                    try {
                        $imageFile->move(
                            $this->getParameter('kernel.project_dir').'/public/uploads/tickets',
                            $newFilename
                        );

                        // Créer une nouvelle entité Image et la lier au ticket
                        $image = new Images();
                        $image->setUrl('uploads/tickets/' . $newFilename);
                        $image->setTicket($ticket);
                        
                        $entityManager->persist($image);
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Erreur lors de l\'upload de l\'image : ' . $e->getMessage());
                    }
                }
            }

            $entityManager->persist($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'Ticket créé avec succès !');

            return $this->redirectToRoute('app_tickets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tickets/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tickets_show', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function show(Request $request, Tickets $ticket, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Créer un nouveau commentaire
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Associer le commentaire au ticket et à l'utilisateur
            $comment->setTicket($ticket);
            $comment->setUser($this->getUser());
            $comment->setCreatedAt(new \DateTimeImmutable());

            // Gérer l'upload des images du commentaire
            /** @var UploadedFile[] $imageFiles */
            $imageFiles = $form->get('imageFiles')->getData();

            if ($imageFiles) {
                foreach ($imageFiles as $imageFile) {
                    // Générer un nom de fichier unique
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                    // Déplacer le fichier dans le dossier d'upload
                    try {
                        $imageFile->move(
                            $this->getParameter('kernel.project_dir').'/public/uploads/comments',
                            $newFilename
                        );

                        // Créer une nouvelle entité Image et la lier au commentaire
                        $image = new Images();
                        $image->setUrl('uploads/comments/' . $newFilename);
                        $image->setComment($comment);
                        
                        $entityManager->persist($image);
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Erreur lors de l\'upload de l\'image : ' . $e->getMessage());
                    }
                }
            }

            $entityManager->persist($comment);
            $entityManager->flush();

            // Message de confirmation
            $this->addFlash('success', 'Commentaire ajouté avec succès !');

            // Rediriger vers la même page pour éviter la resoumission du formulaire
            return $this->redirectToRoute('app_tickets_show', ['id' => $ticket->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tickets/show.html.twig', [
            'ticket' => $ticket,
            'commentForm' => $form,
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_tickets_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Tickets $ticket, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(TicketsType::class, $ticket);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_tickets_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('tickets/edit.html.twig', [
    //         'ticket' => $ticket,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_tickets_delete', methods: ['POST'])]
    public function delete(Request $request, Tickets $ticket, EntityManagerInterface $entityManager): Response
    {

        $this->denyAccessUnlessGranted('TICKET_DELETE', $ticket);
        if ($this->isCsrfTokenValid('delete' . $ticket->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tickets_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/status/{id}', name: 'app_tickets_update_status', methods: ['POST'])]
    public function updateStatus(Request $request, Tickets $ticket, EntityManagerInterface $entityManager, StatusRepository $statusRepository): Response
    {
        $this->denyAccessUnlessGranted('TICKET_UPDATE_STATUS', $ticket);
        if ($this->isCsrfTokenValid('update_status' . $ticket->getId(), $request->getPayload()->getString('_token'))) {
            $submittedStatus = $request->getPayload()->get('status');

            $enum = match ($submittedStatus) {
                'Open', 'open', 'OPEN' => StatusEnum::OPEN,
                'In Progress', 'in progress', 'IN_PROGRESS' => StatusEnum::IN_PROGRESS,
                'Resolved', 'resolved', 'RESOLVED' => StatusEnum::RESOLVED,
            };

            if ($enum){
                if ($status = $statusRepository->findOneBy(['status' => $enum])){
                    $ticket->setStatus($status);
                    $entityManager->flush();
                    $this->addFlash('success', 'Status updated successfully');
                } else {
                    $this->addFlash('error', 'Invalid status');
                }
            } else {
                $this->addFlash('error', 'Invalid status');
            }
        }

        return $this->redirectToRoute('app_tickets_show', ['id' => $ticket->getId()], Response::HTTP_SEE_OTHER);
    }
}

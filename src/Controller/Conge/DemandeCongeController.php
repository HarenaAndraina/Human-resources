<?php

namespace App\Controller\Conge;

use App\Entity\Conge\DemandeConge;
use App\Enum\StatutConge;
use App\Form\DemandeCongeType;
use App\Repository\Conge\DemandeCongeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/demande/conge')]
final class DemandeCongeController extends AbstractController
{
    #[Route(name: 'app_demande_conge_index', methods: ['GET'])]
    public function index(DemandeCongeRepository $demandeCongeRepository): Response
    {
        return $this->render('conge/demande_conge/index.html.twig', [
            'demande_conges' => $demandeCongeRepository->findEnAttente(),
        ]);
    }

    #[Route('/new', name: 'app_demande_conge_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demandeConge = new DemandeConge();
        $form = $this->createForm(DemandeCongeType::class, $demandeConge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demandeConge);
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_conge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('conge/demande_conge/new.html.twig', [
            'demande_conge' => $demandeConge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_conge_show', methods: ['GET'])]
    public function show(DemandeConge $demandeConge): Response
    {
        return $this->render('conge/demande_conge/show.html.twig', [
            'demande_conge' => $demandeConge,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_demande_conge_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DemandeConge $demandeConge, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DemandeCongeType::class, $demandeConge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_conge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('conge/demande_conge/edit.html.twig', [
            'demande_conge' => $demandeConge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_conge_delete', methods: ['POST'])]
    public function delete(Request $request, DemandeConge $demandeConge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeConge->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($demandeConge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demande_conge_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/update_status', name: 'demande_conge_update_status', methods: ['POST'])]
    public function updateStatus(Request $request, DemandeCongeRepository $demandeCongeRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        // Get data from the AJAX request
        $id = $request->request->get('id');
        $newStatus = $request->request->get('status');
        // Find the offer by id
        $demandeConge = $demandeCongeRepository->find($id);
        // Attempt to convert newStatus to StatutOffreEmploi enum
        try {
            $enumStatus = StatutConge::from($newStatus);
        } catch (\ValueError $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Invalid status value'], 400);
        }

        // Update the status
        $demandeConge->setStatus($enumStatus);

        // Persist changes using the EntityManager
        $entityManager->persist($demandeConge);
        $entityManager->flush();

        // Return a JSON response
        return new JsonResponse(['status' => 'success', 'message' => 'Status updated']);
    }
}

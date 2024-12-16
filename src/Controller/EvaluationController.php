<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Entity\DetailEvaluation;
use App\Form\EvaluationType;
use App\Repository\EvaluationRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/evaluation')]
final class EvaluationController extends AbstractController
{
    #[Route(name: 'app_evaluation_index', methods: ['GET'])]
    public function index(EvaluationRepository $evaluationRepository): Response
    {
        return $this->render('evaluation/index.html.twig', [
            'evaluations' => $evaluationRepository->findAll(),
        ]);
    }

    #[Route('/evaluation/new/{id}', name: 'app_evaluation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, string $id, EntityManagerInterface $entityManager, 
        UtilisateurRepository $utilisateurRepository, EvaluationRepository $evaluationRepository): Response
    {
        // Récupérer l'utilisateur à évaluer
        $utilisateur = $utilisateurRepository->find($id);
        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // Créer une nouvelle entité Evaluation
        $evaluation = new Evaluation();
        $evaluation->setUtilisateur($utilisateur);

        // Générer l'ID avec le préfixe 'EVAL'
        $nextEvalId = $entityManager->getConnection()->fetchOne('SELECT nextval(\'eval_id_seq\')');
        $formattedId = 'EVAL' . str_pad($nextEvalId, 3, '0', STR_PAD_LEFT);

        $evaluation->setId($formattedId); 

        $form = $this->createForm(EvaluationType::class, $evaluation, [
            'excluded_user_id' => $id 
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $juge = $form->get('juge')->getData(); 

            $evaluation->setJuge($juge);

            $detailEvaluationData = $form->get('detailEvaluation')->getData();

            $comportement = floatval($detailEvaluationData['comportement'] ?? 0);
            $attitude = floatval($detailEvaluationData['attitude'] ?? 0);
            $competence = floatval($detailEvaluationData['competence'] ?? 0);
            $connaissance = floatval($detailEvaluationData['connaissance'] ?? 0);
            $administrative = floatval($detailEvaluationData['administrative'] ?? 0);

            // Calculer la moyenne
            $moyenne = ($comportement + $attitude + $competence + $connaissance + $administrative) / 5;

            // Créer les entités et les persister
            $detailEvaluation = new DetailEvaluation();
            $detailEvaluation->setEvaluation($evaluation);
            $detailEvaluation->setComportement($comportement);
            $detailEvaluation->setAttitude($attitude);
            $detailEvaluation->setCompetence($competence);
            $detailEvaluation->setConnaissance($connaissance);
            $detailEvaluation->setAdministrative($administrative);

            $evaluation->setScoreMoyenne($moyenne);

            $entityManager->persist($evaluation);
            $entityManager->persist($detailEvaluation);
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index');
        }

        return $this->render('evaluation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/{id}', name: 'app_evaluation_show', methods: ['GET'])]
    public function show(Evaluation $evaluation): Response
    {
        return $this->render('evaluation/show.html.twig', [
            'evaluation' => $evaluation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evaluation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evaluation $evaluation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evaluation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evaluation/edit.html.twig', [
            'evaluation' => $evaluation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evaluation_delete', methods: ['POST'])]
    public function delete(Request $request, Evaluation $evaluation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evaluation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($evaluation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evaluation_index', [], Response::HTTP_SEE_OTHER);
    }
}

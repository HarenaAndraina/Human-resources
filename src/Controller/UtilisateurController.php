<?php

namespace App\Controller;

use App\Entity\DetailEvaluation;
use App\Entity\Evaluation;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\ContratRepository;
use App\Repository\DetailEvaluationRepository;
use App\Repository\EvaluationRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/utilisateur')]
final class UtilisateurController extends AbstractController
{
    #[Route(name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }

    #[Route('/tri',name: 'app_utilisateur_tri', methods: ['GET'])]
    public function triUtilisateur(Request $request, UtilisateurRepository $utilisateurRepository): Response
    {
    // Récupérer le paramètre 'tri' du formulaire (par défaut 'connaissance')
    $tri = $request->query->get('tri', 'connaissance');

    // Appeler la méthode appropriée en fonction de la valeur de 'tri'
    switch ($tri) {
        case 'experience':
            $utilisateurs = $utilisateurRepository->findUtilisateursParExperience();
            break;
        case 'note':
            $utilisateurs = $utilisateurRepository->findUtilisateursTriParNote();
            break;
        case 'connaissance':
        default:
            $utilisateurs = $utilisateurRepository->findUtilisateursParConnaissance();
            break;
    }

    // Passer la variable 'tri' pour garder l'état de la sélection dans le formulaire
    return $this->render('utilisateur/index.html.twig', [
        'utilisateurs' => $utilisateurs,
        'tri' => $tri,
    ]);
}


    #[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer une nouvelle instance d'utilisateur
        $utilisateur = new Utilisateur();

        // Créer le formulaire
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données de contrat à partir de l'utilisateur
            $contrat = $utilisateur->getContrat();
            if ($contrat) {
                // Associer le type de contrat, date de début, et durée
                $typeContrat = $contrat->getType();
                $dateDebut = $contrat->getDateDebut();
                $duree = $contrat->getDuree();

                // Vérifier si toutes les informations requises pour le contrat sont présentes
                if ($typeContrat && $dateDebut) {
                    $entityManager->persist($contrat);
                    $entityManager->flush();

                    $contratId = $contrat->getId();
                    $this->addFlash('success', "Contrat inséré avec succès, ID: $contratId");
                } else {
                    $this->addFlash('error', 'Les informations du contrat sont incomplètes.');
                    return $this->redirectToRoute('app_utilisateur_new');
                }
            }

            // Associer le contrat à l'utilisateur
            $utilisateur->setContrat($contrat);

            // Ajouter les autres informations de l'utilisateur
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur ajouté avec succès.');
            return $this->redirectToRoute('utilisateur_details', [
                'id' => $utilisateur->getId()
            ]);
        }

        // Rendre le formulaire si non soumis ou non valide
        return $this->render('utilisateur/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/utilisateur/{id}', name: 'utilisateur_details', methods: ['GET'])]
    public function details(string $id, UtilisateurRepository $utilisateurRepository, DetailEvaluationRepository $detailEvaluationRepository, EvaluationRepository $evaluationRepository): Response
    {
        $utilisateur = $utilisateurRepository->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException("L'utilisateur avec l'id $id n'a pas été trouvé.");
        }

        $evaluations = $evaluationRepository->findEvaluationsByUtilisateur($id);
        $contrat = $utilisateur->getContrat();  // C'est ici que vous obtenez le contrat
        $detailsEvaluations = [];
        foreach ($evaluations as $evaluation) {
            $details = $detailEvaluationRepository->findByEvaluation($evaluation->getId());
            $detailsEvaluations[$evaluation->getId()] = $details;
        }

        $moyenne =$evaluationRepository->calculerEvaluationMoyenne($utilisateur);

        // Renvoyer la vue avec les informations
        return $this->render('utilisateur/details.html.twig', [
            'utilisateur' => $utilisateur,
            'evaluations' => $evaluations,
            'contrat' => $contrat, // Passer le contrat à la vue
            'detailsEvaluations' => $detailsEvaluations,
            'moyenne'=>$moyenne,
        ]);
    }

    #[Route("/evaluation/{id}", name:"details_evaluation_utilisateur")]
    public function evaluationsUtilisateur(string $id, DetailEvaluationRepository $evaluationRepository): Response
    {
        $detailsEvaluations = $evaluationRepository->findByUtilisateurId($id);

        return $this->render('evaluation/details.html.twig', [
            'detailsEvaluations' => $detailsEvaluations,
            'id'=>$id,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}

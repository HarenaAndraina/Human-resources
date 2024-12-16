<?php

namespace App\Repository;

use App\Entity\Departement;
use App\Entity\DetailEvaluation;
use App\Entity\DetailsContrat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Departement>
 */
class DetailEvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailEvaluation::class);
    }
    public function findByEvaluation($evaluationId)
    {
        return $this->createQueryBuilder('de')
            ->innerJoin('de.evaluation', 'e') // Jointure avec l'entité Evaluation
            ->where('e.id = :evaluationId')    // Filtre par ID d'évaluation
            ->setParameter('evaluationId', $evaluationId)
            ->orderBy('e.dateEvaluation', 'DESC') // Trie par date d'évaluation (optionnel)
            ->getQuery()
            ->getResult();
    }

    public function findByUtilisateurId(string $utilisateurId): array
    {
        return $this->createQueryBuilder('d')
            ->join('d.evaluation', 'e')
            ->where('e.utilisateur = :id')
            ->setParameter('id', $utilisateurId)
            ->getQuery()
            ->getResult();
    }


}

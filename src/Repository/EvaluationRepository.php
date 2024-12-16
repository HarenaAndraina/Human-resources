<?php

namespace App\Repository;

use App\Entity\Departement;
use App\Entity\Evaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Utilisateur;

/**
 * @extends ServiceEntityRepository<Departement>
 */
class EvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evaluation::class);
    }

     /**
     * Calcule la moyenne des scores pour un utilisateur donné entre deux dates.
     *
     * @param string $utilisateurId L'ID de l'utilisateur.
     * @param \DateTime $dateDebut La date de début.
     * @param \DateTime $dateFin La date de fin.
     *
     * @return float La moyenne des scores.
     */
    public function calculerScoreMoyenne(string $utilisateurId, \DateTime $dateDebut, \DateTime $dateFin): float
    {
        // Construire la requête pour obtenir la moyenne des scores
        $qb = $this->createQueryBuilder('e')
            ->select('AVG(e.scoreMoyenne)') 
            ->where('e.utilisateur = :utilisateurId') 
            ->andWhere('e.dateEvaluation BETWEEN :dateDebut AND :dateFin') 
            ->setParameter('utilisateurId', $utilisateurId)
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin);

        // Exécuter la requête et retourner la moyenne
        return (float) $qb->getQuery()->getSingleScalarResult();
    }

    public function findEvaluationsByUtilisateur(string $utilisateurId): array
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.utilisateur', 'u') // Crée une jointure sur l'entité Utilisateur
            ->where('u.id = :utilisateur_id') // Utilise le champ id de l'entité Utilisateur
            ->setParameter('utilisateur_id', $utilisateurId)
            ->orderBy('e.dateEvaluation', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // src/Repository/EvaluationRepository.php

    public function calculerEvaluationMoyenne(Utilisateur $utilisateur): ?float
    {
        $qb = $this->createQueryBuilder('e')
            ->select('AVG(e.scoreMoyenne) as moyenne')
            ->where('e.utilisateur = :utilisateur')
            ->andWhere('e.dateEvaluation <= :dateAujourdHui')
            ->setParameter('utilisateur', $utilisateur)
            ->setParameter('dateAujourdHui', new \DateTimeImmutable('today'));

        $result = $qb->getQuery()->getSingleScalarResult();

        return $result ? (float) $result : null; // Retourne null s'il n'y a pas d'évaluations
    }




}

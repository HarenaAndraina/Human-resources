<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use App\Entity\DetailEvaluation;
use App\Entity\Evaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;


/**
 * @extends ServiceEntityRepository<Utilisateur>
 */
class UtilisateurRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    public function getUserOrderByConnaissance(){

    }

    public function getUserOrderByNote(){

    }

    public function getUserOrderByExperience(){
        
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Utilisateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findUtilisateursTriParNote()
    {
        return $this->createQueryBuilder('u')
            ->addSelect('AVG(e.scoreMoyenne) AS HIDDEN avg_note') // Calcul de la moyenne (masquée)
            ->leftJoin(Evaluation::class, 'e', 'WITH', 'e.utilisateur = u')
            ->where('e.dateEvaluation <= :currentDate')
            ->setParameter('currentDate', new \DateTime())
            ->groupBy('u.id')
            ->orderBy('avg_note', 'DESC')
            ->getQuery()
            ->getResult();
    }



    public function findUtilisateursParExperience()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.debutActivite', 'DESC')  // Trier par début d'activité (du plus récent au plus ancien)
            ->getQuery()
            ->getResult();
    }

    public function findUtilisateursParConnaissance()
    {
        return $this->createQueryBuilder('u')
            ->select('u', 'AVG(d.connaissance) AS HIDDEN avg_connaissance')
            ->leftJoin(Evaluation::class, 'e', 'WITH', 'e.utilisateur = u') // Joindre les évaluations des utilisateurs
            ->leftJoin(DetailEvaluation::class, 'd', 'WITH', 'd.evaluation = e') // Joindre les détails des évaluations
            ->groupBy('u.id') // Grouper par utilisateur
            ->orderBy('avg_connaissance', 'DESC') // Trier par moyenne des connaissances
            ->getQuery()
            ->getResult();
    }
    


    //    /**
    //     * @return Utilisateur[] Returns an array of Utilisateur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Utilisateur
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

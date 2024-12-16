<?php

namespace App\Repository;

use App\Dto\DepartementWithEmployeeCountDTO;
use App\Entity\Departement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Departement>
 */
class DepartementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departement::class);
    }

    /**
     * @return DepartementWithEmployeeCountDTO[]
     */
    public function findAllWithEmployeeCount(): array
    {
        return $this->createQueryBuilder("d")
            ->select("NEW App\Dto\DepartementWithEmployeeCountDTO(d.id, d.nom, d.description, COUNT(employes.id) AS nbre_employes)")
            ->leftJoin("d.utilisateurs", "employes")
            ->groupBy("d.id")
            ->orderBy("d.id")
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Departement[] Returns an array of Departement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Departement
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function selectLivrePartieTitre($value)
    {
        return $this->createQueryBuilder('l')
            ->where("l.titre LIKE :value")
            ->setParameter('value', '%'.$value.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function selectLivreAnnee($dateMin , $dateMax)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('YEAR(l.date_de_parution) >= :dateMin')
            ->andWhere('YEAR(l.date_de_parution) <= :dateMax')
            ->setParameter('dateMin', $dateMin)
            ->setParameter('dateMax', $dateMax)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function selectListeLivreParite()
    {
        return $this->createQueryBuilder('l')
        ->join('l.auteur_livre', 'a')
        ->groupBy('l.id')
        ->having('SUM(CASE WHEN a.sexe = :homme THEN 1 ELSE 0 END) = SUM(CASE WHEN a.sexe = :femme THEN 1 ELSE 0 END)  ')
        ->setParameter('homme', "M")
        ->setParameter('femme', "F")
            
        ->getQuery()
        ->getResult();
    }


    public function selectListeAuteurNationalite()
    {
        return $this->createQueryBuilder('l')
        ->join('l.auteur_livre', 'a')
        ->groupBy('l.id')
        ->having('COUNT(a.nationalite) = COUNT( DISTINCT a.nationalite)  ')
        ->getQuery()
        ->getResult();
    }





      public function selectLivreParDateEtNote($dateMin , $dateMax, $noteMin, $noteMax)
      {
          return $this->createQueryBuilder('l')
              ->andWhere('l.date_de_parution >= :dateMin')
              ->andWhere('l.date_de_parution <= :dateMax')
              ->andWhere('l.note >= :noteMin')
              ->andWhere('l.note <= :noteMax')
              ->setParameter('dateMin', $dateMin)
              ->setParameter('dateMax', $dateMax)
              ->setParameter('noteMin', $noteMin)
              ->setParameter('noteMax', $noteMax)
              ->orderBy('l.id', 'ASC')
              ->getQuery()
              ->getResult()
          ;
      }
}

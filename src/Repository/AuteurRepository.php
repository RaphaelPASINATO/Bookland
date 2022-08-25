<?php

namespace App\Repository;

use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Auteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auteur[]    findAll()
 * @method Auteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auteur::class);
    }

    // /**
    //  * @return Auteur[] Returns an array of Auteur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Auteur
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function selectListeAuteurTroisLivres()
    {
        return $this->createQueryBuilder('a')
            ->join('a.livre_ecrit', 'l')
            ->groupBy('a.id')
            ->having('COUNT(l.id) >= :some_count')
            ->setParameter('some_count', 3)
            ->getQuery()
            ->getResult()
        ;
    }

    
    public function selectListeAuteurGenre()
    {
        return $this->createQueryBuilder('a')
        ->select('DISTINCT a.id, a.nom_prenom, a.sexe, a.date_de_naissance, a.nationalite ')
        ->addSelect('g.nom')
        ->join('a.livre_ecrit', 'l')
        ->join('l.livre_genre', 'g')
        ->OrderBy('a.date_de_naissance,l.date_de_parution')
        ->getQuery()
        ->getResult();
    }

    public function selectAuteurGenre($id)
    {
        return $this->createQueryBuilder('a')
        ->select('DISTINCT g.nom ')
        ->join('a.livre_ecrit', 'l')
        ->join('l.livre_genre', 'g')
        ->where('a.id = :id')
        ->setParameter('id',$id)
        ->getQuery()
        ->getResult();
    }


    public function modifierNoteAuteurf($note, $id)
    {
        return $this->createQueryBuilder('a')
        ->update('App\Entity\Livre l')
        ->join('a.livre_ecrit', 'l')
        ->set('l.note','l.note + :note')
        ->where('a.id = :id')
        ->andWhere('l.note + :note < 20')
        ->setParameter('id',$id)
        ->setParameter('note', $note)
        ->getQuery()
        ->getResult();
    }


    
    public function modifierNoteAuteur($note, $id) {        
        $query = $this->getEntityManager()
                      ->createQuery("UPDATE App\Entity\Livre l
                                           set l.note = l.note + :note
                                           WHERE l.note + :note <= 20 AND  l.id IN (SELECT i.id FROM App\Entity\Livre i JOIN i.auteur_livre a WHERE a.id = :id )")
                      ->setParameter('id', $id)
                      ->setParameter('note', $note);

        return $query->getResult();
      }
}

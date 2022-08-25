<?php

namespace App\Repository;

use App\Entity\Genre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
/**
 * @method Genre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Genre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Genre[]    findAll()
 * @method Genre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Genre::class);
    }

    // /**
    //  * @return Genre[] Returns an array of Genre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Genre
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
  

    public function nombreTotalPagesParGenre($idGenre)
    {
        return $this->createQueryBuilder('g')
            ->select('SUM(l.nbpages) AS nbpagestotal')
            ->leftjoin('g.livres', 'l')
            ->where('g.id = :idGenre')
            ->setParameter('idGenre', $idGenre)
            ->getQuery()
            ->getResult(Query::HYDRATE_SINGLE_SCALAR);
    }

    public function nombreMoyenPagesParGenre($idGenre)
    {
        return $this->createQueryBuilder('g')
            ->select('AVG(l.nbpages) AS nbpagestotal')
            ->leftjoin('g.livres', 'l')
            ->where('g.id = :idGenre')
            ->setParameter('idGenre', $idGenre)
            ->getQuery()
            ->getResult(Query::HYDRATE_SINGLE_SCALAR);
    }


    public function selectListeGenreAuteur()
    {
        return $this->createQueryBuilder('g')
        ->select('DISTINCT g.nom, g.id ')
        ->addSelect('a.nom_prenom')
        ->join('g.livres', 'l')
        ->join('l.auteur_livre', 'a')
        ->OrderBy('g.nom, l.date_de_parution')
        ->getQuery()
        ->getResult();
    }

    
   
   

    public function supprimerGenreAucunLivre($id) {        
        $query = $this->getEntityManager()
                      ->createQuery("DELETE FROM App\Entity\Genre g
                                           WHERE g.id =  :id AND ( SELECT COUNT(h.id) FROM App\Entity\Livre l JOIN l.livre_genre h WHERE h.id = :id ) = 0")
                      ->setParameter('id', $id);

        return $query->getResult();
      }

}

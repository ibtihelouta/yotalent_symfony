<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Video>
 *
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    public function save(Video $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Video $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
// trier par nom d'utilisateur
public function sortByIdV() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.idvid', 'ASC')
        ->getQuery()
        ->getResult();
}

// trier par nombre de votes
public function sortByNbVotes() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.nomvid', 'DESC')
        ->getQuery()
        ->getResult();
}

// rechercher par nom d'utilisateur
public function findByUsername($idvid) {
    return $this->createQueryBuilder('e')
        ->where('e.idvid LIKE :idvid')
        ->setParameter('idvid', '%'.$idvid.'%')
        ->getQuery()
        ->getResult();
}

// rechercher par nombre de votes
public function findByNom($nomvid) {
    return $this->createQueryBuilder('e')
        ->where('e.nomvid = :nomvid')
        ->setParameter('nomvid', $nomvid)
        ->getQuery()
        ->getResult();
}

public function findByUrl($url) {
    return $this->createQueryBuilder('e')
        ->where('e.url = :url')
        ->setParameter('url', $url)
        ->getQuery()
        ->getResult();
}
public function searchAdvanced($idvid, $nomvid, $url) {
    $query = $this->createQueryBuilder('p')
        ->where('p.idvid LIKE :idvid OR p.nomvid LIKE :nomvid OR p.url LIKE :url')
        ->setParameter('idvid', '%'.$idvid.'%')
        ->setParameter('nomvid', '%'.$nomvid.'%')
        ->setParameter('url', '%'.$url.'%')
        ->getQuery();

    return $query->getResult();
}


}
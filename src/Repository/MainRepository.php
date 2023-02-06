<?php

namespace App\Repository;

use App\Entity\Main;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Main::class);
    }
    public function findArticleByTitle($searchFormValue)
    {
        $qb = $this->createQueryBuilder('main')
            ->select('main')
            ->orderBy('main.posted', 'DESC');

        // Si la clé title n'est pas empty dans les données qui viennent du formulaire de recherche, on entre dans la condition
        if (!empty($searchFormValue['title'])) {
            // passe le titre au sein d'un arguent LIKE
            $qb->andWhere('main.title LIKE :title')
                ->setParameter('title', '%' . $searchFormValue['title'] . '%');
        }


        // Prépare la requete
        $query = $qb->getQuery();
        // Exécute la requête
        return $query->execute();
    }
}

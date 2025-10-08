<?php

namespace App\Repository;

use App\Entity\Tickets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Tickets>
 */
class TicketsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tickets::class);
    }
    /**
     * @return Paginator
     */
    
    
    public function findPaginated(int $page = 1, int $limit = 20, array $filters = []): Paginator
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.created_at', 'DESC');

        // Filtre par type
        if (!empty($filters['type'])) {
            $query->andWhere('t.type = :type')
            ->setParameter('type', $filters['type']);
        }

        // Filtre par stack/technologie
        if (!empty($filters['stack'])) {
            $query->andWhere('t.stack = :stack')
            ->setParameter('stack', $filters['stack']);
        }

        // Filtre par status
        if (!empty($filters['status'])) {
            $query->leftJoin('t.status', 's')
            ->andWhere('s.status = :status')
            ->setParameter('status', $filters['status']);
        }

        // Recherche textuelle
        if (!empty($filters['search'])) {
            $query->andWhere('t.title LIKE :search OR t.content LIKE :search')
            ->setParameter('search', '%' . $filters['search'] . '%');
        }

        $query = $query->setFirstResult(($page - 1) * $limit)
                    ->setMaxResults($limit)
                    ->getQuery();

        return new Paginator($query);
    }
}

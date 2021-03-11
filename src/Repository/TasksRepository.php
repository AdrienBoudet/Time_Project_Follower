<?php

namespace App\Repository;

use App\Entity\Tasks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tasks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tasks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tasks[]    findAll()
 * @method Tasks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TasksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tasks::class);
    }

    /**
     * @return Tasks[] Returns an array of Tasks objects
     */

    public function findByDateRange($start, $end)
    {
        $stmt = $this->createQueryBuilder('d');

        if(!empty($start) && !empty($end))
        {
            $stmt->where('d.startAt >= :start')
            ->andWhere('d.endAt <= :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->orderBy('d.endAt', 'DESC')
        ;
        }
        return  $stmt->getQuery()->getResult();
    }
}

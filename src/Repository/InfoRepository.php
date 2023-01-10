<?php

namespace App\Repository;

use App\Entity\Info;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Info>
 *
 * @method Info|null find($id, $lockMode = null, $lockVersion = null)
 * @method Info|null findOneBy(array $criteria, array $orderBy = null)
 * @method Info[]    findAll()
 * @method Info[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Info::class);
    }

    public function save(Info $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Info $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
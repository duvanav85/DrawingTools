<?php

namespace App\Repository;

use App\Entity\Drawing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
include('draw.class.php');

/**
 * @extends ServiceEntityRepository<Drawing>
 *
 * @method Drawing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Drawing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Drawing[]    findAll()
 * @method Drawing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrawingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Drawing::class);
    }

    public function add(Drawing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Drawing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function draw(): void
    {
        $draw = new Draw();
        $draw->consoleListener();
    }
    
}

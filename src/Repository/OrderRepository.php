<?php

namespace App\Repository;

use App\DTO\OrderProductDTO;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getOrderProductByUser(int $userId): array
    {
        $dql = ' SELECT 
        o.order_ext_id,
        o.id order_id,
        o.created_at,
        op.quantity, 
        pv.name,
        pv.id product_id,
        mu.url_link
        FROM App\Entity\Order o
        JOIN App\Entity\OrderProduct op WITH o.id = op.OrderID
        JOIN op.Product pv
        JOIN pv.mediaUrls mu
        WHERE o.user = :user_id AND mu.is_main = 1';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('user_id', $userId);

        return $query->getResult();
    }

}

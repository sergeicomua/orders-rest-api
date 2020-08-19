<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository{
    public function findAllByIds($ids)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select * from products where id IN (?)';
        $stmt = $stmt = $conn->executeQuery($sql,
            array($ids),
            array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository{
    private $statuses = array(
        1 => 'новый',
        2 => 'оплачен'
    );

    public function getStatuses(){
        return $this->statuses;
    }

    public function getStatusById(int $status_id){
        return array_key_exists($status_id, $this->statuses) ? $this->statuses[$status_id] : false;
    }

    public function getTotalOrder(int $order_id):float {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT SUM(price) as total FROM order_details '.
               'WHERE order_id = :order_id';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['order_id' => $order_id]);

        $result = $stmt->fetch();


        return $result ? $result['total'] : 0;
    }
}
<?php

namespace  App\Entities;
/**
 * @Entity(
 *     repositoryClass="App\Repository\ProductRepository")
 * @Table(name="products")
 */
class Product
{
    /**
     * @id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string", name="name", length=32, unique=true, nullable=true)
     */
    private $name;

    /**
     * @Column(type="decimal")
     */
    private $price;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

}
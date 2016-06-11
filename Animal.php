<?php
/**
 * Created by PhpStorm.
 * Author: Amy Luo
 * Date: 2016-06-11
 * Time: 16:26
 */

abstract class Animal
{
    private $sn;

    abstract public function call();

    public function __construct($serialNumber)
    {
        $this->setSn($serialNumber);
    }

    /**
     * @param mixed $sn
     */
    public function setSn($sn)
    {
        $this->sn = $sn;
    }

    /**
     * @return mixed
     */
    public function getSn()
    {
        return $this->sn;
    }
}

class Goat extends Animal
{

    public function call()
    {
        echo "Bah Bah ~";
    }
}

class Sheep extends Animal
{
    public function call()
    {
        echo "Moo Moo ~";
    }
}
<?php

/*
 * This file is generate by DiaBundle for symfony package
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Genemu\Bundle\DoctrineExtraBundle\Entity\Method
 * 
 * @ORM\Table(
 *     name="genemu_doctrine_extra_method"
 * )
 * @ORM\Entity(
 *     repositoryClass="Genemu\Bundle\DoctrineExtraBundle\Entity\Repository\Method"
 * )
 */
class Method extends Entity
{
    /**
     * @var string $name
     * 
     * @ORM\Column(type="string", length="128")
     */
    protected $name;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Controller $controller
     * 
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Controller",
     *     inversedBy="methods"
     * )
     * @ORM\JoinColumn(
     *     name="controller_id",
     *     referencedColumnName="id"
     * )
     */
    protected $controller;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routings
     * 
     * @ORM\OneToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Routing",
     *     mappedBy="method",
     *     cascade={"all"}
     * )
     */
    protected $routings;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->routings = new ArrayCollection();
    }

    /**
     * get name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * set name
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * set controller
     * 
     * @param Genemu\Bundle\DoctrineExtraBundle\Entity\Controller $controller
     */
    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    /**
     * get controller
     * 
     * @return Genemu\Bundle\DoctrineExtraBundle\Entity\Controller $controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * add routings
     * 
     * @param Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routings
     */
    public function addRoutings(Routing $routings)
    {
        $this->routings->add($routings);
    }

    /**
     * get routings
     * 
     * @return Doctrine\Common\Collections\ArrayCollection $routings
     */
    public function getRoutings()
    {
        return $this->routings;
    }

}
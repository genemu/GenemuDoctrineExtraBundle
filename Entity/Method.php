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
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Genemu\Bundle\DoctrineExtraBundle\Entity\Method
 *
 * @ORM\Table(
 *     name="genemu_doctrine_extra_method",
 *     indexes={
 *         @ORM\Index(name="method_idx", columns={"name"})
 *     }
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
     * @Assert\Type(type="string"),
     * @Assert\MaxLength(128)
     */
    protected $name;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Controller $controller
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Controller",
     *     inversedBy="methods",
     *     cascade={"all"}
     * )
     * @ORM\JoinColumn(
     *     name="controller_id",
     *     referencedColumnName="id",
     *     nullable="false",
     *     onDelete="CASCADE"
     * )
     */
    protected $controller;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routings
     *
     * @ORM\OneToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Routing",
     *     mappedBy="method",
     *     cascade={"persist", "update", "detach", "merge"}
     * )
     * @ORM\OrderBy({"order" = "DESC"})
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
     * @param Controller $controller
     */
    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    /**
     * get controller
     *
     * @return Controller $controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * add routings
     *
     * @param Routing $routing
     */
    public function addRouting(Routing $routing)
    {
        $this->routings->add($routing);
    }

    /**
     * get routings
     *
     * @return ArrayCollection $routings
     */
    public function getRoutings()
    {
        return $this->routings;
    }

    /**
     * toString
     *
     * @return string controller name
     */
    public function __toString()
    {
        $controller = $this->getController();
        $bundle = $controller->getBundle();

        return $bundle->getName().':'.$controller->getName().':'.$this->name;
    }
}

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
 * Genemu\Bundle\DoctrineExtraBundle\Entity\RoutingParameter
 *
 * @ORM\Table(
 *     name="genemu_doctrine_extra_routingparameter"
 * )
 * @ORM\Entity(
 *     repositoryClass="Genemu\Bundle\DoctrineExtraBundle\Entity\Repository\RoutingParameter"
 * )
 */
class RoutingParameter extends Entity
{
    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length="128")
     */
    protected $name;

    /**
     * @var string $defaultValue
     *
     * @ORM\Column(nullable="true", name="default_value", type="string", length="128")
     */
    protected $defaultValue;

    /**
     * @var string $requirement
     *
     * @ORM\Column(nullable="true", type="string", length="128")
     */
    protected $requirement;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routings
     *
     * @ORM\ManyToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Routing",
     *     mappedBy="routingparameters"
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
     * get defaultValue
     *
     * @return string $defaultValue
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * set defaultValue
     *
     * @param string $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * get requirement
     *
     * @return string $requirement
     */
    public function getRequirement()
    {
        return $this->requirement;
    }

    /**
     * set requirement
     *
     * @param string $requirement
     */
    public function setRequirement($requirement)
    {
        $this->requirement = $requirement;
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
     * @return Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routings
     */
    public function getRoutings()
    {
        return $this->routings;
    }
}

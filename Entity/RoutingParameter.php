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
     * @Assert\Type(type="string"),
     * @Assert\NotNull(),
     * @Assert\MaxLength(128)
     */
    protected $name;

    /**
     * @var string $defaultValue
     *
     * @ORM\Column(nullable="true", name="default_value", type="string", length="128")
     * @Assert\Type(type="string"),
     * @Assert\MaxLength(128)
     */
    protected $default;

    /**
     * @var string $requirement
     *
     * @ORM\Column(nullable="true", type="string", length="128")
     * @Assert\Type(type="string"),
     * @Assert\MaxLength(128)
     */
    protected $requirement;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routing
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Routing",
     *     inversedBy="parameters",
     *     cascade={"persist", "detach", "update", "merge"}
     * )
     * @ORM\JoinColumn(
     *     name="routing_id",
     *     referencedColumnName="id",
     *     nullable="false",
     *     onDelete="CASCADE"
     * )
     */
    protected $routing;

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
     * get default
     *
     * @return string $default
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * set default
     *
     * @param string $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
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
     * add routing
     *
     * @param Routing $routin
     */
    public function setRouting(Routing $routing)
    {
        $this->routing = $routing;
    }

    /**
     * get routing
     *
     * @return Routing $routing
     */
    public function getRouting()
    {
        return $this->routing;
    }
}

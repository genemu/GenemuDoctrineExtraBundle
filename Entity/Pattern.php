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
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Genemu\Bundle\DoctrineExtraBundle\Entity\Pattern
 *
 * @ORM\Table(
 *     name="genemu_doctrine_extra_pattern",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="name",
 *             columns={"name"}
 *         )
 *     },
 *     indexes={
 *         @ORM\Index(name="pattern_idx", columns={"name"})
 *     }
 * )
 * @ORM\Entity(
 *     repositoryClass="Genemu\Bundle\DoctrineExtraBundle\Entity\Repository\Pattern"
 * )
 * @DoctrineAssert\UniqueEntity("name")
 */
class Pattern extends Entity
{
    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length="128", unique="true")
     * @Assert\Type(type="string"),
     * @Assert\NotNull(),
     * @Assert\MaxLength(128)
     */
    protected $name;

    /**
     * @var string $locale
     *
     * @ORM\Column(type="string", length="5")
     * @Assert\Locale()
     */
    protected $locale;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routing
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Routing",
     *     inversedBy="patterns",
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
     * get locale
     *
     * @return string $locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * set locale
     *
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
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

    /**
     * set routing
     *
     * @param Routing $routing
     */
    public function setRouting(Routing $routing)
    {
        $this->routing = $routing;
    }

    /**
     * toString
     *
     * @return string $name
     */
    public function __toString()
    {
        return $this->name;
    }
}

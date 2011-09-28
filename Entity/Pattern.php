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

/**
 * Genemu\Bundle\DoctrineExtraBundle\Entity\Pattern
 *
 * @ORM\Table(
 *     name="genemu_doctrine_extra_pattern"
 * )
 * @ORM\Entity(
 *     repositoryClass="Genemu\Bundle\DoctrineExtraBundle\Entity\Repository\Pattern"
 * )
 */
class Pattern extends Entity
{
    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length="128")
     */
    protected $name;

    /**
     * @var string $locale
     *
     * @ORM\Column(type="string", length="5")
     */
    protected $locale;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routing
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Routing",
     *     inversedBy="patterns"
     * )
     * @ORM\JoinColumn(
     *     name="routing_id",
     *     referencedColumnName="id"
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
     * @return Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routing
     */
    public function getRouting()
    {
        return $this->routing;
    }

    /**
     * set routing
     *
     * @param Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routing
     */
    public function setRouting(Routing $routing)
    {
        $this->routing = $routing;
    }

    /**
     * to string
     *
     * @return string $name
     */
    public function __toString()
    {
        return $this->name;
    }
}

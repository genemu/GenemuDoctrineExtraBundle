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
 * Genemu\Bundle\DoctrineExtraBundle\Entity\View
 *
 * @ORM\Table(
 *     name="genemu_doctrine_extra_view"
 * )
 * @ORM\Entity(
 *     repositoryClass="Genemu\Bundle\DoctrineExtraBundle\Entity\Repository\View"
 * )
 */
class View extends Entity
{
    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length="128")
     */
    protected $name;

    /**
     * @var string $format
     *
     * @ORM\Column(type="string", length="4")
     */
    protected $format;

    /**
     * @var string $engine
     *
     * @ORM\Column(type="string", length="4")
     */
    protected $engine;

    /**
     * @var string $directory
     *
     * @ORM\Column(nullable="true", type="string", length="128")
     */
    protected $directory;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle $bundle
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle",
     *     inversedBy="views"
     * )
     * @ORM\JoinColumn(
     *     name="bundle_id",
     *     referencedColumnName="id"
     * )
     */
    protected $bundle;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routings
     *
     * @ORM\OneToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Routing",
     *     mappedBy="view",
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
     * get format
     *
     * @return string $format
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * set format
     *
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * get engine
     *
     * @return string $engine
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * set engine
     *
     * @param string $engine
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;
    }

    /**
     * get directory
     *
     * @return string $directory
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * set directory
     *
     * @param string $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    /**
     * set bundle
     *
     * @param Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle $bundle
     */
    public function setBundle(Bundle $bundle)
    {
        $this->bundle = $bundle;
    }

    /**
     * get bundle
     *
     * @return Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle $bundle
     */
    public function getBundle()
    {
        return $this->bundle;
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

    /**
     * toString
     *
     * @return string template name
     */
    public function __toString()
    {
        $bundle = $this->getBundle();

        return $bundle->getName().':'.$this->directory.':'.$this->name.'.'.$this->format.'.'.$this->engine;
    }
}

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
 * Genemu\Bundle\DoctrineExtraBundle\Entity\View
 *
 * @ORM\Table(
 *     name="genemu_doctrine_extra_view",
 *     indexes={
 *         @ORM\Index(name="view_idx", columns={"name", "format", "engine", "directory"})
 *     }
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
     * @Assert\Type(type="string"),
     * @Assert\NotNull(),
     * @Assert\MaxLength(128)
     */
    protected $name;

    /**
     * @var string $format
     *
     * @ORM\Column(type="string", length="4")
     * @Assert\Type(type="string"),
     * @Assert\NotNull(),
     * @Assert\MaxLength(4),
     * @Assert\Choice(choices={"html", "css", "json", "js"})
     */
    protected $format;

    /**
     * @var string $engine
     *
     * @ORM\Column(type="string", length="4")
     * @Assert\Type(type="string"),
     * @Assert\NotNull(),
     * @Assert\MaxLength(4),
     * @Assert\Choice(choices={"twig", "php"})
     */
    protected $engine;

    /**
     * @var string $directory
     *
     * @ORM\Column(nullable="true", type="string", length="128")
     * @Assert\Type(type="string"),
     * @Assert\MaxLength(128)
     */
    protected $directory;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle $bundle
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle",
     *     inversedBy="views",
     *     cascade={"all"}
     * )
     * @ORM\JoinColumn(
     *     name="bundle_id",
     *     referencedColumnName="id",
     *     nullable="false",
     *     onDelete="CASCADE"
     * )
     */
    protected $bundle;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routings
     *
     * @ORM\OneToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Routing",
     *     mappedBy="view",
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
     * @param Bundle $bundle
     */
    public function setBundle(Bundle $bundle)
    {
        $this->bundle = $bundle;
    }

    /**
     * get bundle
     *
     * @return Bundle $bundle
     */
    public function getBundle()
    {
        return $this->bundle;
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
     * @return string template name
     */
    public function __toString()
    {
        $bundle = $this->getBundle();

        return $bundle->getName().':'.$this->directory.':'.$this->name.'.'.$this->format.'.'.$this->engine;
    }
}

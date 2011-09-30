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
use Doctrine\Common\Collections\ArrayCollection;
use Genemu\Bundle\DoctrineExtraBundle\Model\RoutingInterface;

/**
 * Genemu\Bundle\DoctrineExtraBundle\Entity\Routing
 *
 * @ORM\Table(
 *     name="genemu_doctrine_extra_routing",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="name",
 *             columns={"name"}
 *         )
 *     },
 *     indexes={
 *         @ORM\Index(name="routing_idx", columns={"name"})
 *     }
 * )
 * @ORM\Entity(
 *     repositoryClass="Genemu\Bundle\DoctrineExtraBundle\Entity\Repository\Routing"
 * )
 * @DoctrineAssert\UniqueEntity("name")
 */
class Routing extends Entity implements RoutingInterface
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
     * @var integer $order
     *
     * @ORM\Column(nullable="true", type="integer", name="ordering")
     * @Assert\Type(type="integer")
     */
    protected $order;

    /**
     * @var boolean $publish
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="boolean"),
     * @Assert\Notnull()
     */
    protected $publish;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Pattern $patterns
     *
     * @ORM\OneToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Pattern",
     *     mappedBy="routing",
     *     cascade={"all"},
     *     orphanRemoval="true"
     * )
     * @ORM\OrderBy({"name" = "DESC"})
     * @Assert\Valid()
     */
    protected $patterns;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\RoutingParameter $parameters
     *
     * @ORM\OneToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\RoutingParameter",
     *     mappedBy="routing",
     *     cascade={"all"},
     *     orphanRemoval="true"
     * )
     * @ORM\OrderBy({"name" = "DESC"})
     * @Assert\Valid()
     */
    protected $parameters;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Method $method
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Method",
     *     inversedBy="routings",
     *     cascade={"persist", "update", "detach", "merge"}
     * )
     * @ORM\JoinColumn(
     *     name="method_id",
     *     referencedColumnName="id",
     *     nullable="false",
     *     onDelete="CASCADE"
     * )
     * @Assert\Valid()
     */
    protected $method;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\View $view
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\View",
     *     inversedBy="routings",
     *     cascade={"persist", "update", "detach", "merge"}
     * )
     * @ORM\JoinColumn(
     *     name="view_id",
     *     referencedColumnName="id",
     *     nullable="false",
     *     onDelete="CASCADE"
     * )
     * @Assert\Valid()
     */
    protected $view;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Cache $cache
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Cache",
     *     inversedBy="routings",
     *     cascade={"all"}
     * )
     * @ORM\JoinColumn(
     *     name="cache_id",
     *     referencedColumnName="id"
     * )
     */
    protected $cache;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->publish = false;
        $this->patterns = new ArrayCollection();
        $this->parameters = new ArrayCollection();
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
     * get pattern
     *
     * @return ArrayCollection $patterns
     */
    public function getPatterns()
    {
        return $this->patterns;
    }

    /**
     * get pattern
     *
     * @param string $locale
     *
     * @return Pattern\null $pattern
     */
    public function getPattern($locale = 'en')
    {
        foreach ($this->patterns as $pattern) {
            if ($locale == $pattern->getLocale()) {
                return $pattern;
            }
        }

        return null;
    }

    /**
     * add pattern
     *
     * @param Pattern $pattern
     */
    public function addPattern(Pattern $pattern)
    {
        $this->patterns->add($pattern);
        $pattern->setRouting($this);
    }

    /**
     * get order
     *
     * @return integer $order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * set order
     *
     * @param integer $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * get publish
     *
     * @return boolean $publish
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * set publish
     *
     * @param boolean $publish
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;
    }

    /**
     * toogle publish
     */
    public function tooglePublish()
    {
        $this->publish = $this->publish?false:true;
    }

    /**
     * add parameters
     *
     * @param RoutingParameter $parameters
     */
    public function addParameter(RoutingParameter $parameter)
    {
        $this->parameters->add($parameter);
        $parameter->setRouting($this);
    }

    /**
     * get parameters
     *
     * @return ArrayCollection $parameters
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * get defaults values
     *
     * @return array defaults values
     */
    public function getDefaults()
    {
        $defaults = array();
        foreach ($this->parameters as $parameter) {
            if ($default = $parameter->getDefault()) {
                $defaults[$parameter->getName()] = $default;
            }
        }

        return $defaults;
    }

    /**
     * get requirements
     *
     * @return array $requirements
     */
    public function getRequirements()
    {
        $requirements = array();
        foreach ($this->parameters as $parameter) {
            if ($requirement = $parameter->getRequirement()) {
                $requirements[$parameter->getName()] = $requirement;
            }
        }

        return $requirements;
    }

    /**
     * set method
     *
     * @param Method $method
     */
    public function setMethod(Method $method)
    {
        $this->method = $method;
    }

    /**
     * get method
     *
     * @return Method $method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * set view
     *
     * @param View $view
     */
    public function setView(View $view)
    {
        $this->view = $view;
    }

    /**
     * get view
     *
     * @return View $view
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * set cache
     *
     * @param Cache $cache
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * get cache
     *
     * @return Cache $cache
     */
    public function getCache()
    {
        return $this->cache;
    }
}

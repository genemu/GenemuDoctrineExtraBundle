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
use Symfony\Component\Routing\Route;
use Genemu\Bundle\DoctrineExtraBundle\Routing\RoutingInterface;

/**
 * Genemu\Bundle\DoctrineExtraBundle\Entity\Routing
 *
 * @ORM\Table(
 *     name="genemu_doctrine_extra_routing"
 * )
 * @ORM\Entity(
 *     repositoryClass="Genemu\Bundle\DoctrineExtraBundle\Entity\Repository\Routing"
 * )
 */
class Routing extends Entity implements RoutingInterface
{
    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length="128", unique="true")
     */
    protected $name;

    /**
     * @var string $pattern
     *
     * @ORM\Column(type="string", length="512", unique="true")
     */
    protected $pattern;

    /**
     * @var integer $ordering
     *
     * @ORM\Column(nullable="true", type="integer")
     */
    protected $ordering;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\RoutingParameter $routingparameters
     *
     * @ORM\ManyToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\RoutingParameter",
     *     inversedBy="routings"
     * )
     * @ORM\JoinTable(
     *     name="genemu_doctrine_extra_routings_routingparameters",
     *     joinColumns={@ORM\JoinColumn(
     *         name="routing_id",
     *         referencedColumnName="id"
     *     )},
     *     inverseJoinColumns={@ORM\JoinColumn(
     *         name="routingparameter_id",
     *         referencedColumnName="id"
     *     )}
     * )
     */
    protected $routingparameters;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Method $method
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Method",
     *     inversedBy="routings"
     * )
     * @ORM\JoinColumn(
     *     name="method_id",
     *     referencedColumnName="id"
     * )
     */
    protected $method;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\View $view
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\View",
     *     inversedBy="routings"
     * )
     * @ORM\JoinColumn(
     *     name="view_id",
     *     referencedColumnName="id"
     * )
     */
    protected $view;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->routingparameters = new ArrayCollection();
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
     * @return string $pattern
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * set pattern
     *
     * @param string $pattern
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * get ordering
     *
     * @return integer $ordering
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * set ordering
     *
     * @param integer $ordering
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;
    }

    /**
     * add routingparameters
     *
     * @param Genemu\Bundle\DoctrineExtraBundle\Entity\RoutingParameter $routingparameters
     */
    public function addRoutingparameters(RoutingParameter $routingparameters)
    {
        $this->routingparameters->add($routingparameters);
    }

    /**
     * get routingparameters
     *
     * @return Genemu\Bundle\DoctrineExtraBundle\Entity\RoutingParameter $routingparameters
     */
    public function getRoutingparameters()
    {
        return $this->routingparameters;
    }

    /**
     * set method
     *
     * @param Genemu\Bundle\DoctrineExtraBundle\Entity\Method $method
     */
    public function setMethod(Method $method)
    {
        $this->method = $method;
    }

    /**
     * get method
     *
     * @return Genemu\Bundle\DoctrineExtraBundle\Entity\Method $method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * set view
     *
     * @param Genemu\Bundle\DoctrineExtraBundle\Entity\View $view
     */
    public function setView(View $view)
    {
        $this->view = $view;
    }

    /**
     * get view
     *
     * @return Genemu\Bundle\DoctrineExtraBundle\Entity\View $view
     */
    public function getView()
    {
        return $this->view;
    }

    public function getRoute()
    {
        if (!$this->method) {
            return null;
        }

        $requirements = array();
        $defaults = array(
            '_controller' => $this->method->__toString()
        );

        if ($this->view) {
            $defaults['_genemu_template'] = $this->view->__toString();
        }

        foreach ($this->routingparameters as $parameter) {
            $name = $parameter->getName();

            if ($default = $parameter->getDefaultValue()) {
                $defaults[$name] = $default;
            }

            if ($requirement = $parameter->getRequirement()) {
                $requirements[$name] = $requirement;
            }
        }

        return new Route($this->pattern, $defaults, $requirements);
    }
}

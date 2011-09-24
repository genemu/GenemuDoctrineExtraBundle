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
 * Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle
 * 
 * @ORM\Table(
 *     name="genemu_doctrine_extra_bundle"
 * )
 * @ORM\Entity(
 *     repositoryClass="Genemu\Bundle\DoctrineExtraBundle\Entity\Repository\Bundle"
 * )
 */
class Bundle extends Entity
{
    /**
     * @var string $name
     * 
     * @ORM\Column(type="string", length="128", unique="true")
     */
    protected $name;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Controller $controllers
     * 
     * @ORM\OneToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Controller",
     *     mappedBy="bundle",
     *     cascade={"all"}
     * )
     */
    protected $controllers;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\View $views
     * 
     * @ORM\OneToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\View",
     *     mappedBy="bundle",
     *     cascade={"all"}
     * )
     */
    protected $views;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->controllers = new ArrayCollection();
        $this->views = new ArrayCollection();
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
     * add controllers
     * 
     * @param Genemu\Bundle\DoctrineExtraBundle\Entity\Controller $controllers
     */
    public function addControllers(Controller $controllers)
    {
        $this->controllers->add($controllers);
    }

    /**
     * get controllers
     * 
     * @return Doctrine\Common\Collections\ArrayCollection $controllers
     */
    public function getControllers()
    {
        return $this->controllers;
    }

    /**
     * add views
     * 
     * @param Genemu\Bundle\DoctrineExtraBundle\Entity\View $views
     */
    public function addViews(View $views)
    {
        $this->views->add($views);
    }

    /**
     * get views
     * 
     * @return Doctrine\Common\Collections\ArrayCollection $views
     */
    public function getViews()
    {
        return $this->views;
    }

}
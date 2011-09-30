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

/**
 * Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle
 *
 * @ORM\Table(
 *     name="genemu_doctrine_extra_bundle",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="name",
 *             columns={"name"}
 *         )
 *     },
 *     indexes={
 *         @ORM\Index(name="bundle_idx", columns={"name"})
 *     }
 * )
 * @ORM\Entity(
 *     repositoryClass="Genemu\Bundle\DoctrineExtraBundle\Entity\Repository\Bundle"
 * )
 * @DoctrineAssert\UniqueEntity("name")
 */
class Bundle extends Entity
{
    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length="128", unique="true")
     * @Assert\NotNull(),
     * @Assert\MaxLength(128),
     * @Assert\Type(type="string")
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
     * @ORM\OrderBy({"name" = "DESC"})
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
     * @ORM\OrderBy({"directory" = "DESC", "name" = "DESC", "format" = "DESC", "engine" = "DESC"})
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
     * @param Controller $controller
     */
    public function addController(Controller $controller)
    {
        $this->controllers->add($controller);
    }

    /**
     * get controllers
     *
     * @return ArrayCollection $controllers
     */
    public function getControllers()
    {
        return $this->controllers;
    }

    /**
     * add views
     *
     * @param View $view
     */
    public function addView(View $view)
    {
        $this->views->add($view);
    }

    /**
     * get views
     *
     * @return ArrayCollection $views
     */
    public function getViews()
    {
        return $this->views;
    }
}

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
 * Genemu\Bundle\DoctrineExtraBundle\Entity\Controller
 *
 * @ORM\Table(
 *     name="genemu_doctrine_extra_controller",
 *     indexes={
 *         @ORM\Index(name="controller_idx", columns={"name"})
 *     }
 * )
 * @ORM\Entity(
 *     repositoryClass="Genemu\Bundle\DoctrineExtraBundle\Entity\Repository\Controller"
 * )
 */
class Controller extends Entity
{
    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length="128")
     * @Assert\Type(type="string"),
     * @Assert\MaxLength(128)
     */
    protected $name;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle $bundle
     *
     * @ORM\ManyToOne(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle",
     *     inversedBy="controllers",
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
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Method $methods
     *
     * @ORM\OneToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Method",
     *     mappedBy="controller",
     *     cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "DESC"})
     */
    protected $methods;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->methods = new ArrayCollection();
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
     * add methods
     *
     * @param Method $method
     */
    public function addMethod(Method $method)
    {
        $this->methods->add($method);
    }

    /**
     * get methods
     *
     * @return ArrayCollection $methods
     */
    public function getMethods()
    {
        return $this->methods;
    }
}

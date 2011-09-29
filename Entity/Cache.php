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
 * Genemu\Bundle\DoctrineExtraBundle\Entity\Cache
 *
 * @ORM\Table(
 *     name="genemu_doctrine_extra_cache"
 * )
 * @ORM\Entity(
 *     repositoryClass="Genemu\Bundle\DoctrineExtraBundle\Entity\Repository\Cache"
 * )
 */
class Cache extends Entity
{
    /**
     * @var boolean $public
     *
     * @ORM\Column(type="boolean", nullable="true")
     */
    protected $public;

    /**
     * @var string $name
     *
     * @ORM\Column(type="datetime", nullable="true")
     */
    protected $expires;

    /**
     * @var interger $smaxage
     *
     * @ORM\Column(type="integer", nullable="true")
     */
    protected $smaxage;

    /**
     * @var integer $maxage
     *
     * @ORM\Column(type="integer", nullable="true")
     */
    protected $maxage;

    /**
     * @var Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routings
     *
     * @ORM\OneToMany(
     *     targetEntity="Genemu\Bundle\DoctrineExtraBundle\Entity\Routing",
     *     mappedBy="cache",
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
     * get public
     *
     * @return boolean $public
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * set public
     *
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
    }

    /**
     * get expires
     *
     * @return DateTime $expires
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * set expires
     *
     * @param DateTime $expires
     */
    public function setExpires(\DateTime $expires)
    {
        $this->expires = $expires;
    }

    /**
     * get smaxage
     *
     * @return integer $smaxage
     */
    public function getSmaxage()
    {
        return $this->smaxage;
    }

    /**
     * set smaxage
     *
     * @param integer $smaxage
     */
    public function setSmaxage($smaxage)
    {
        $this->smaxage = $smaxage;
    }

    /**
     * get maxage
     *
     * @return integer $maxage
     */
    public function getMaxage()
    {
        return $this->maxage;
    }

    /**
     * set maxage
     *
     * @param integer $maxage
     */
    public function setMaxage($maxage)
    {
        $this->maxage = $maxage;
    }

    /**
     * add routings
     *
     * @param Genemu\Bundle\DoctrineExtraBundle\Entity\Routing $routing
     */
    public function addRouting(Routing $routing)
    {
        $this->routings->add($routing);
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
}

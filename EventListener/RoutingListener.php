<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Genemu\Bundle\DoctrineExtraBundle\Config\Resource\DoctrineResource;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Pattern;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Routing;
use Genemu\Bundle\DoctrineExtraBundle\Entity\RoutingParameter;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Cache;

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class RoutingListener
{
    protected $resource;

    /**
     * Construct
     *
     * @param DoctrineResource $resource
     */
    public function __construct(DoctrineResource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Postpresist
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->checkEntity($args->getEntity());
    }

    /**
     * PostUpdate
     *
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->checkEntity($args->getEntity());
    }

    /**
     * PostUpdate
     *
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $this->checkEntity($args->getEntity());
    }

    /**
     * Check entity
     *
     * @param Entity $entity
     */
    protected function checkEntity($entity)
    {
        if (
            $entity instanceof Routing ||
            $entity instanceof Pattern ||
            $entity instanceof RoutingParameter ||
            $entity instanceof Cache
        ) {
            $this->resource->updated($entity->getUpdatedAt()->getTimestamp());
        }
    }
}

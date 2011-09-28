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

class RoutingListener
{
    protected $resource;

    public function __construct(DoctrineResource $resource)
    {
        $this->resource = $resource;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $class = new \ReflectionClass($args->getEntity());

        if ($class->implementsInterface('Genemu\Bundle\DoctrineExtraBundle\ROuting\RoutingInterface')) {
            $this->resource->updated();
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $class = new \ReflectionClass($args->getEntity());

        if ($class->implementsInterface('Genemu\Bundle\DoctrineExtraBundle\ROuting\RoutingInterface')) {
            $this->resource->updated();
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $class = new \ReflectionClass($args->getEntity());

        if ($class->implementsInterface('Genemu\Bundle\DoctrineExtraBundle\ROuting\RoutingInterface')) {
            $this->resource->updated();
        }
    }
}

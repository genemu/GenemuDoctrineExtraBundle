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

class RoutingListener
{
    protected $resource;

    public function __construct(DoctrineResource $resource)
    {
        $this->resource = $resource;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        if ($this->checkEntity($args->getEntity())) {
            $this->resource->updated();
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        if ($this->checkEntity($args->getEntity())) {
            $this->resource->updated();
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        if ($this->checkEntity($args->getEntity())) {
            $this->resource->updated();
        }
    }

    protected function checkEntity($entity)
    {
        if (
            $entity instanceof Routing ||
            $entity instanceof Pattern ||
            $entity instanceof RoutingParameter
        ) {
            return true;
        }

        return false;
    }
}

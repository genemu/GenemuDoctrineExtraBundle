<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\Routing\Loader;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Routing\RouteCollection;
use Genemu\Bundle\DoctrineExtraBundle\Config\Resource\DoctrineResource;

class DoctrineRouteLoader implements LoaderInterface
{
    protected $registry;
    protected $resource;

    public function __construct(Registry $registry, DoctrineResource $resource)
    {
        $this->registry = $registry;
        $this->resource = $resource;
        $this->resource->updated();
    }

    public function load($entityName, $type = null)
    {
        $repository = $this->registry->getRepository($entityName);

        $collection = new RouteCollection();
        $collection->addResource($this->resource->getResource());

        foreach ($repository->findAll() as $routing) {
            if ($route = $routing->getRoute()) {
                $collection->add($routing->getName(), $routing->getRoute());
            }
        }

        return $collection;
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && ('doctrine' === $type);
    }

    public function getResolver()
    {
    }

    public function setResolver(LoaderResolver $resolver)
    {
    }
}

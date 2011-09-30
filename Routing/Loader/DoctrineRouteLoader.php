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
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Genemu\Bundle\DoctrineExtraBundle\Config\Resource\DoctrineResource;

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class DoctrineRouteLoader implements LoaderInterface
{
    protected $registry;
    protected $resource;

    /**
     * Construct
     *
     * @param Registry         $registry
     * @param DoctrineResource $resource
     */
    public function __construct(Registry $registry, DoctrineResource $resource)
    {
        $this->registry = $registry;
        $this->resource = $resource;
    }

    /**
     * Load routing to Entity
     *
     * @param string $entityName
     * @param string $type
     */
    public function load($entityName, $type = null)
    {
        $repository = $this->registry->getRepository($entityName);

        $collection = new RouteCollection();
        $collection->addResource($this->resource);

        foreach ($repository->findRoutingAll() as $routing) {
            $name = $routing->getName();
            $requirements = $routing->getRequirements();
            $defaults = array(
                '_controller' => $routing->getMethod()->__toString()
            );

            if ($template = $routing->getView()) {
                $defaults['_genemu_template'] = $template->__toString();
            }

            if ($cache = $routing->getCache()) {
                $defaults = array_merge($defaults, array(
                    '_genemu_cache' => true,
                    '_genemu_cache_lastmodified' => $routing->getUpdatedAt()->getTimestamp()
                ));

                foreach ($cache->toArray() as $key => $value) {
                    $defaults['_genemu_cache_'.$key] = $value;
                }
            }

            $defaults = array_merge($defaults, $routing->getDefaults());

            foreach ($routing->getPatterns() as $pattern) {
                $locale = $pattern->getLocale();

                $defaults['_genemu_culture'] = $locale;

                $route = new Route($pattern->getName(), $defaults, $requirements);

                if ($locale == 'en') {
                    $collection->add($name, $route);
                }

                $collection->add($name.'.'.$locale, $route);
                $collection->add($name.'.'.$locale.'_'.strtoupper($name), $route);
            }
        }

        return $collection;
    }

    /**
     * Test supports
     *
     * @param string $resource
     * @param string $type
     *
     * @return boolean
     */
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

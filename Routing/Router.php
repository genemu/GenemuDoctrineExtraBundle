<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Config\ConfigCache;

/**
 * This Router creates the Loader when the cache is empty or database is modify
 *
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class Router extends BaseRouter
{
    protected $repository;
    protected $date;

    /**
     * {@inheritedoc}
     */
    public function __construct(ContainerInterface $container, $resource, array $options = array(), RequestContext $context = null, array $defaults = array())
    {
        parent::__construct($container, $resource, $options, $context, $defaults);

        $this->repository = $container->get('doctrine')->getRepository('GenemuDoctrineExtraBundle:Routing');
        $this->date = $this->repository->getMaxDate();
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteCollection()
    {
        if (null === $this->collection) {
            $this->collection = parent::getRouteCollection();

            $routings = $this->repository->findAllWithParameters();
            foreach ($routings as $routing) {
                if ($route = $routing->getRoute()) {
                    $this->collection->add($routing->getRouting()->getName(), $route);
                }
            }
        }

        return $this->collection;
    }

    /**
     * {@inheritdoc}
     */
    public function getMatcher()
    {
        return $this->getKey('matcher');
    }

    /**
     * {@inheritdoc}
     */
    public function getGenerator()
    {
        return $this->getKey('generator');
    }

    /**
     * Verify if modif file or page database
     *
     * @param string      $flie
     * @param ConfigCache $class
     *
     * @return boolean
     */
    protected function isFresh($file, $class)
    {
        if (!$file->isFresh($class)) {
            return false;
        }

        $date = new \DateTime();
        $date->setTimestamp(filemtime($file));

        return ($date < $this->date)?false:true;
    }

    /**
     * Create and return file cache
     *
     * @param string $key
     *
     * @return ConfigCache $this->$key
     */
    protected function getKey($key)
    {
        if (null !== $this->$key) {
            return $this->$key;
        }

        if (null === $this->options['cache_dir'] || null === $this->options[$key.'_cache_class']) {
            $class = $this->options[$key.'_class'];
            return $this->$key = new $class($this->getRouteCollection(), $this->context, $this->defaults);
        }

        $class = $this->options[$key.'_cache_class'];
        $cache = new ConfigCache($this->options['cache_dir'].'/'.$class.'.php', $this->options['debug']);

        if (!$this->isFresh($cache, $class)) {
            $dumper = new $this->options[$key.'_dumper_class']($this->getRouteCollection());

            $options = array('class' => $class, 'base_class' => $this->options[$key.'_base_class']);
            $cache->write($dumper->dump($options), $this->getRouteCollection()->getResources());
        }

        require_once $cache;

        return $this->$key = new $class($this->context, $this->defaults);
    }
}

<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\Config\Resource;

use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\ConfigCache;

/**
 * Doctrine Resource
 *
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class DoctrineResource
{
    protected $file;
    protected $cache;

    public function __construct($kernel)
    {
        $this->file = $kernel->getCacheDir().'/genemu/routing.php';
        $this->cache = new ConfigCache($this->file, $kernel->isDebug());
    }

    public function updated()
    {
        $date = new \DateTime();

        $this->cache->write($date->getTimestamp());
    }

    public function isFresh($timestamp)
    {
        if (!is_file($this->file)) {
            return false;
        }

        if (filemtime($this->file) > $timestamp) {
            return false;
        }

        return true;
    }

    public function getResource()
    {
        return new FileResource($this->file);
    }
}

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

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Resource\ResourceInterface;

/**
 * Doctrine Resource
 *
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class DoctrineResource implements ResourceInterface
{
    protected $file;
    protected $cache;

    public function __construct(Kernel $kernel)
    {
        $this->file = $kernel->getCacheDir().'/genemu/routing.php';
        $this->cache = new ConfigCache($this->file, $kernel->isDebug());
    }

    public function updated($timestamp)
    {
        $this->cache->write($timestamp);
    }

    public function isFreshCache(ConfigCache $cache)
    {
        if (!is_file($cache->__toString())) {
            return false;
        }

        $timestamp = filemtime($cache->__toString());
        if (!$this->isFresh($timestamp) || !$cache->isFresh()) {
            $this->updated($timestamp);

            return false;
        }

        return true;
    }

    public function isFresh($timestamp)
    {
        if (!is_file($this->file)) {
            return false;
        }

        if (!file_get_contents($this->file)) {
            $this->updated($timestamp);

            return true;
        }

        if (file_get_contents($this->file) > $timestamp) {
            return false;
        }

        return true;
    }

    public function getResource()
    {
        return $this->file;
    }

    public function __toString()
    {
        return $this->file;
    }
}

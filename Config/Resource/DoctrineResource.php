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

class DoctrineResource
{
    protected $cache;

    public function __construct($kernel)
    {
        $this->cache = new ConfigCache($kernel->getCacheDir().'/genemu/routing.php', $kernel->isDebug());
    }

    public function updated()
    {
        $date = new \DateTime();

        $this->cache->write($date->getTimestamp());
    }

    public function getResource()
    {
        return new FileResource($this->cache->__toString());
    }
}

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

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Genemu\Bundle\DoctrineExtraBundle\Config\Resource\DoctrineResource;

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class CacheListener
{
    protected $resource;

    public function __construct(DoctrineResource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * {@inheritedoc}
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        if (!$request->attributes->get('_genemu_cache')) {
            return;
        }

        if (!$response->isSuccessful()) {
            return;
        }

        if ($expires = $request->attributes->get('_genemu_cache_expires')) {
            $date = \DateTime::createFromFormat('U', $expires, new \DateTimeZone('UTC'));

            $response->setExpires($date);
        }

        if ($smaxage = $request->attributes->get('_genemu_cache_smaxage')) {
            $response->setSharedMaxAge($smaxage);
        }

        if ($maxage = $request->attributes->get('_genemu_cache_maxage')) {
            $response->setMaxAge($maxage);
        }

        if ($request->attributes->get('_genemu_cache_public')) {
            $response->setPublic();
        }

        //$timestamp = file_get_contents($this->resource->getResource());
        //$date = \DateTime::createFromFormat('U', $timestamp, new \DateTimeZone('UTC'));

        //$response->setLastModified($date);

        return $response;
    }
}

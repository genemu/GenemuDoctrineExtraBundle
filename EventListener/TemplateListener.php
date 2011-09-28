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

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class TemplateListener
{
    protected $container;

    /**
     * Construct
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritedoc}
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();
        $parameters = $event->getControllerResult();

        if (!$parameters) {
            $parameters = array();
        }

        if (!is_array($parameters)) {
            return $parameters;
        }

        if (!$template = $request->get('_genemu_template')) {
            return $parameters;
        }

        $event->setResponse(new Response($this->container->get('templating')->render($template, $parameters)));
    }
}

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
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class TemplateListener
{
    protected $templating;
    protected $session;

    /**
     * Construct
     *
     * @param TwigEngine $templating
     * @param Session $session
     */
    public function __construct(TwigEngine $templating, Session $session)
    {
        $this->templating = $templating;
        $this->session = $session;
    }

    /**
     * {@inheritedoc}
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();
        $parameters = $event->getControllerResult();

        $template = $request->get('_genemu_template');
        if (!$parameters) {
            $parameters = array();
        }

        if (!is_array($parameters) || !$template) {
            return $parameters;
        }

        if ($request->get('_genemu_locale') && '/' != $request->getPathInfo()) {
            $this->session->setLocale($request->get('_genemu_locale'));
        }

        $locale = $this->session->getLocale();
        $parameters['culture'] = ($pos = strpos($locale, '_'))?substr($locale, 0, $pos):$locale;

        $event->setResponse(new Response($this->templating->render($template, $parameters)));
    }
}

<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\Twig\Extension;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Session;

class DoctrineExtension extends \Twig_Extension
{
    protected $router;
    protected $session;

    public function __construct(Router $router, Session $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    public function getFunctions()
    {
        return array(
            'path' => new \Twig_Function_Method($this, 'doDoctrineFilter')
        );
    }

    public function doDoctrineFilter($name, $parameters = array(), $absolute = false)
    {
        /*
        $collection = $this->router->getRouteCollection();

        if (null !== $collection->get($name.'.'.$this->session->getLocale())) {
            return $this->router->generate($name.'.'.$this->session->getLocale(), $parameters, $absolute);
        }
         */

        return $this->router->generate($name, $parameters, $absolute);
    }

    public function getName()
    {
        return 'genemu_extension_doctrine';
    }
}

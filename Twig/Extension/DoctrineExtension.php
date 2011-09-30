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

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class DoctrineExtension extends \Twig_Extension
{
    protected $router;
    protected $session;
    protected $debug;

    /**
     * Construct
     *
     * @param Router $router
     * @param Session $session
     */
    public function __construct(Router $router, Session $session, $debug)
    {
        $this->router = $router;
        $this->session = $session;
        $this->debug = $debug;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'doctrine' => new \Twig_Function_Method($this, 'doDoctrineFilter')
        );
    }

    /**
     * doDoctrineFilter
     * url routing to i18n
     *
     * @param string  $name
     * @param array   $parameters
     * @param boolean $absolute
     *
     * @return string $url
     */
    public function doDoctrineFilter($name, $parameters = array(), $absolute = false)
    {
        if (!$this->debug) {
            if ($this->router->getRouteCollection()->get($name.'.'.$this->session->getLocale())) {
                $name = $name.'.'.$this->session->getLocale();
            }
        }

        return $this->router->generate($name, $parameters, $absolute);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'genemu_extension_doctrine';
    }
}

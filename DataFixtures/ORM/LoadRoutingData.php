<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\CmsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Routing;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Pattern;

class LoadRoutingData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
        foreach (array('index', 'edit', 'new', 'remove', 'publish', 'move') as $name) {
            $pattern = '/routing';

            if (in_array($name, array('edit', 'remove', 'publish'))) {
                $pattern .= '/'.$name.'/{id}';
            } elseif ($name == 'new') {
                $pattern .= '/new';
            } elseif ($name == 'move') {
                $pattern .= '/move/{type}/{id}';
            }

            $route = new Routing();
            $route->setName('routing_'.$name);
            $route->setPublish(true);
            $route->setMethod($this->getReference('genemu_doctrine_extra_method_'.$name));
            $route->setView($this->getReference('genemu_doctrine_extra_view_'.$name));

            $manager->persist($route);

            $pat = new Pattern();
            $pat->setName($pattern);
            $pat->setLocale('en');
            $pat->setRouting($route);

            $manager->persist($pat);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}

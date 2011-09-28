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

class LoadRoutingData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
        foreach (array('index', 'edit', 'new') as $name) {
            $pattern = '/routing';

            if ($name == 'edit') {
                $pattern .= '/edit/{id}';
            } elseif ($name == 'new') {
                $pattern .= '/new';
            }

            $route = new Routing();
            $route->setName('routing_'.$name);
            $route->setPattern($pattern);
            $route->setMethod($this->getReference('genemu_doctrine_extra_method_'.$name));
            $route->setView($this->getReference('genemu_doctrine_extra_view_'.$name));

            $manager->persist($route);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}

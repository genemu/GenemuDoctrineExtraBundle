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
use Genemu\Bundle\DoctrineExtraBundle\Entity\Method;

class LoadMethodData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
        $controller = $this->getReference('genemu_doctrine_extra_controller');

        foreach (array('index', 'edit', 'new', 'remove', 'publish') as $name) {
            $method = new Method();
            $method->setName($name);
            $method->setController($controller);

            $manager->persist($method);

            $this->setReference('genemu_doctrine_extra_method_'.$name, $method);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}

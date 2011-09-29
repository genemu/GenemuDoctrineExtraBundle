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
use Genemu\Bundle\DoctrineExtraBundle\Entity\Controller;

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class LoadControllerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load($manager)
    {
        $controller = new Controller();
        $controller->setName('Routing');
        $controller->setBundle($this->getReference('genemu_doctrine_extra_bundle'));

        $manager->persist($controller);

        $this->setReference('genemu_doctrine_extra_controller', $controller);

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }
}

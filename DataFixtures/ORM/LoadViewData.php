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
use Genemu\Bundle\DoctrineExtraBundle\Entity\View;

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class LoadViewData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load($manager)
    {
        $bundle = $this->getReference('genemu_doctrine_extra_bundle');

        foreach (array('index', 'edit', 'new', 'remove', 'publish', 'move') as $name) {

            if (in_array($name, array('remove', 'publish', 'move'))) {
                $view = $this->getReference('genemu_doctrine_extra_view_index');
            } else {
                $view = new View();
                $view->setName($name);
                $view->setFormat('html');
                $view->setEngine('twig');
                $view->setDirectory('Routing');
                $view->setBundle($bundle);

                $manager->persist($view);
            }

            $this->setReference('genemu_doctrine_extra_view_'.$name, $view);
        }

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

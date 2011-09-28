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
use Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle;

class LoadBundleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
        $bundle = new Bundle();
        $bundle->setName('GenemuDoctrineExtraBundle');

        $manager->persist($bundle);

        $this->setReference('genemu_doctrine_extra_bundle', $bundle);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}

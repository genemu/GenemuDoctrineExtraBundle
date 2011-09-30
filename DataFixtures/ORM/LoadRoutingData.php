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
use Genemu\Bundle\DoctrineExtraBundle\Entity\RoutingParameter;

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class LoadRoutingData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $routings = array(
        'index' => array(
            '/routing'
        ),
        'edit' => array(
            '/routing/edit/{id}',
            array(
                'id' => array(null, '\d+')
            )
        ),
        'new' => array(
            '/routing/new'
        ),
        'remove' => array(
            '/routing/remove/{id}',
            array(
                'id' => array(null, '\d+')
            )
        ),
        'publish' => array(
            '/routing/publish/{id}',
            array(
                'id' => array(null, '\d+')
            )
        ),
        'move' => array(
            '/routing/move/{type}/{id}',
            array(
                'id' => array(null, '\d+'),
                'type' => array('up', 'up|down')
            )
        )
    );

    /**
     * {@inheritdoc}
     */
    public function load($manager)
    {
        foreach ($this->routings as $name => $values) {
            $pattern = new Pattern();
            $pattern->setName($values[0]);
            $pattern->setLocale('en');

            $routing = new Routing();
            $routing->setName('routing_'.$name);
            $routing->setPublish(true);
            $routing->setMethod($this->getReference('genemu_doctrine_extra_method_'.$name));
            $routing->setView($this->getReference('genemu_doctrine_extra_view_'.$name));

            if (isset($values[1])) {
                foreach ($values[1] as $nameP => $params) {
                    $parameter = new RoutingParameter();
                    $parameter->setName($nameP);

                    if (isset($params[0]) && $params[0]) {
                        $parameter->setDefault($params[0]);
                    }

                    if (isset($params[1]) && $params[1]) {
                        $parameter->setRequirement($params[1]);
                    }

                    $manager->persist($parameter);
                    $routing->addParameter($parameter);
                }
            }

            $routing->addPattern($pattern);

            $manager->persist($routing);
            $manager->persist($pattern);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }
}

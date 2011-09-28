<?php

/*
 * This file is generate by DiaBundle for symfony package
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Bundle extends EntityRepository
{
    public function findAllByUpdate()
    {
        $qb = $this->createQueryBuilder('bundle')
            ->select('partial bundle.{id, name}')
            ->addSelect('partial controllers.{id, name}')
            ->addSelect('partial methods.{id, name}')
            ->addSelect('partial views.{id, name, directory, format, engine}')
            ->leftJoin('bundle.controllers', 'controllers')
            ->leftJoin('bundle.views', 'views')
            ->leftJoin('controllers.methods', 'methods');

        $results = array();
        foreach ($qb->getQuery()->getResult() as $bundle) {
            $controllers = array();
            foreach ($bundle->getControllers() as $controller) {
                $methods = array();
                foreach ($controller->getMethods() as $method) {
                    $methods[$method->getName()] = array(
                        'entity' => $method
                    );
                }

                $controllers[$controller->getName()] = array(
                    'entity' => $controller,
                    'methods' => $methods
                );
            }

            $views = array();
            foreach ($bundle->getViews() as $view) {
                $directory = $view->getDirectory();
                $file = $view->getName().'.'.$view->getFormat().'.'.$view->getEngine();

                $views[$directory.':'.$file] = array(
                    'entity' => $view
                );
            }

            $results[$bundle->getName()] = array(
                'entity' => $bundle,
                'controllers' => $controllers,
                'views' => $views
            );
        }

        return $results;
    }
}

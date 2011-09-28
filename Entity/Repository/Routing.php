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

class Routing extends EntityRepository
{
    public function findRoutingAll($publish = true)
    {
        $qb = $this->createQueryBuilder('routing')
            ->leftJoin('routing.patterns', 'patterns')
            ->leftJoin('routing.routingparameters', 'routingparameters')
            ->leftJoin('routing.view', 'view')
            ->leftJoin('view.bundle', 'bundle_view')
            ->leftJoin('routing.method', 'method')
            ->leftJoin('method.controller', 'controller')
            ->leftJoin('controller.bundle', 'bundle_controller');

        $qb->select('partial routing.{id, name, ordering, publish}')
            ->addSelect('partial patterns.{id, name, locale}')
            ->addSelect('partial routingparameters.{id, name, defaultValue, requirement}')
            ->addSelect('partial view.{id, name, format, engine, directory}')
            ->addSelect('partial bundle_view.{id, name}')
            ->addSelect('partial method.{id, name}')
            ->addSelect('partial controller.{id, name}')
            ->addSelect('partial bundle_controller.{id, name}');

        if ($publish) {
            $qb->where($qb->expr()->eq('routing.publish', $qb->expr()->literal(true)));
        }

        $qb->orderBy('routing.ordering');

        return $qb->getQuery()->getResult();
    }

    public function moveUp($node)
    {
        $routings = $this->findRoutingAll(false);

        foreach ($routings as $index => $routing) {
            $routing->setOrdering($index);

            if ($routing->getId() == $node->getId() && $index != 0) {
                $routing->setOrdering($index-1);
                $routings[$index-1]->setOrdering($index+1);
            }
        }
    }

    public function moveDown($node)
    {
        $routings = $this->findRoutingAll(false);
        $exists = false;
        foreach ($routings as $index => $routing) {
            $routing->setOrdering($index);

            if ($exists) {
                $routing->setOrdering($index-1);
                $exists = false;
            }

            if ($routing->getId() == $node->getId() && isset($routings[$index+1])) {
                $routing->setOrdering($index+1);
                $exists = true;
            }
        }
    }
}

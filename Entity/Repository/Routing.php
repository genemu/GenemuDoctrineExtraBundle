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
        $qb = $this->getJoins();

        if ($publish) {
            $qb->where($qb->expr()->eq('routing.publish', $qb->expr()->literal(true)));
        }

        $qb->orderBy('routing.order');

        return $qb->getQuery()->getResult();
    }

    public function findOneById($id)
    {
        $qb = $this->getJoins();
        $qb->where($qb->expr()->eq('routing.id', $qb->expr()->literal($id)));

        $results = $qb->getQuery()->getResult();

        return $results?$results[0]:null;
    }

    public function moveUp($node)
    {
        $routings = $this->findRoutingAll(false);

        foreach ($routings as $index => $routing) {
            $routing->setOrder($index);

            if ($routing->getId() == $node->getId() && $index != 0) {
                $routing->setOrder($index-1);
                $routings[$index-1]->setOrder($index+1);
            }
        }
    }

    public function moveDown($node)
    {
        $routings = $this->findRoutingAll(false);
        $exists = false;
        foreach ($routings as $index => $routing) {
            $routing->setOrder($index);

            if ($exists) {
                $routing->setOrder($index-1);
                $exists = false;
            }

            if ($routing->getId() == $node->getId() && isset($routings[$index+1])) {
                $routing->setOrder($index+1);
                $exists = true;
            }
        }
    }

    protected function getJoins()
    {
        $qb = $this->createQueryBuilder('routing')
            ->leftJoin('routing.patterns', 'patterns')
            ->leftJoin('routing.parameters', 'parameters')
            ->leftJoin('routing.view', 'view')
            ->leftJoin('view.bundle', 'bundle_view')
            ->leftJoin('routing.cache', 'cache')
            ->leftJoin('routing.method', 'method')
            ->leftJoin('method.controller', 'controller')
            ->leftJoin('controller.bundle', 'bundle_controller');

        $qb->select('partial routing.{id, name, order, publish}')
            ->addSelect('partial patterns.{id, name, locale}')
            ->addSelect('partial parameters.{id, name, default, requirement}')
            ->addSelect('partial view.{id, name, format, engine, directory}')
            ->addSelect('partial bundle_view.{id, name}')
            ->addSelect('partial method.{id, name}')
            ->addSelect('partial controller.{id, name}')
            ->addSelect('partial bundle_controller.{id, name}')
            ->addSelect('partial cache.{id, expires, smaxage, maxage, public}');

        return $qb;
    }
}

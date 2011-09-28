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
    public function findAll()
    {
        $qb = $this->createQueryBuilder('routing')
            ->leftJoin('routing.routingparameters', 'routingparameters')
            ->leftJoin('routing.view', 'view')
            ->leftJoin('view.bundle', 'bundle_view')
            ->leftJoin('routing.method', 'method')
            ->leftJoin('method.controller', 'controller')
            ->leftJoin('controller.bundle', 'bundle_controller');

        $qb->select('partial routing.{id, pattern, name, ordering}')
            ->addSelect('partial routingparameters.{id, name, defaultValue, requirement}')
            ->addSelect('partial view.{id, name, format, engine, directory}')
            ->addSelect('partial bundle_view.{id, name}')
            ->addSelect('partial method.{id, name}')
            ->addSelect('partial controller.{id, name}')
            ->addSelect('partial bundle_controller.{id, name}');

        return $qb->getQuery()->getResult();
    }
}

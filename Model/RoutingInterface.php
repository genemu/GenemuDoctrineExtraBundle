<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\Model;

/**
 * This Router creates the Loader when the cache is empty or database is modify
 *
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
interface RoutingInterface
{
    public function getName();

    public function getRequirements();

    public function getDefaults();

    public function getMethod();

    public function getView();

    public function getCache();

    public function getPatterns();
}

<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Controller;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Method;
use Genemu\Bundle\DoctrineExtraBundle\Entity\View;

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class UpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('doctrinextra:fixtures:update')
            ->setDescription('Update Bundles, controllers and views to bundles');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}

<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class RoutingType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('patterns', 'collection', array(
                'type' => new PatternType(),
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->add('method', 'entity', array(
                'class' => 'GenemuDoctrineExtraBundle:Method',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('method')
                        ->addSelect('controller')
                        ->addSelect('bundle')
                        ->leftJoin('method.controller', 'controller')
                        ->leftJoin('controller.bundle', 'bundle')
                        ->orderBy('bundle.name, controller.name, method.name');
                }
            ))
            ->add('view', 'entity', array(
                'class' => 'GenemuDoctrineExtraBundle:View',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('view')
                        ->addSelect('bundle')
                        ->leftJoin('view.bundle', 'bundle')
                        ->orderBy('bundle.name, view.directory, view.name');
                }
            ))
            ->add('routingparameters', 'collection', array(
                'type' => new RoutingParameterType(),
                'allow_add' => true,
                'allow_delete' => true
            ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Genemu\Bundle\DoctrineExtraBundle\Entity\Routing'
        );
    }

    public function getName()
    {
        return 'genemu_routing';
    }
}

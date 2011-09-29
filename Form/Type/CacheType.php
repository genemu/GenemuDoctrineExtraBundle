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

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class CacheType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('public')
            ->add('expires', 'datetime', array('attr' => array('class' => 'date')))
            ->add('smaxage')
            ->add('maxage');
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Genemu\Bundle\DoctrineExtraBundle\Entity\Cache'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'genemu_cache';
    }
}

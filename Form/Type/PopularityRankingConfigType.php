<?php

/*
 * This file is part of the Top
 *
 * Copyright (C) 2017 Lin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\PopularityRanking\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PopularityRankingConfigType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
            ->add('quantity', 'text', array(
                'label' => '商品数量',
                'required' => true,
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Range(
                      array(
                        'min' => 1,
                        'minMessage' => '0以下利用できません。',
                        'max' => 12,
                        'maxMessage' => '13以上利用できません。'
                      )
                    )
                ),
            ));
    }

    public function getName()
    {
        return 'popularity_ranking_config';
    }

}

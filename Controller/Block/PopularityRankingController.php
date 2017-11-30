<?php

/*
 * This file is part of the Top
 *
 * Copyright (C) 2017 Lin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\PopularityRanking\Controller\Block;

use Eccube\Application;
use Eccube\Common\Constant;
use Symfony\Component\HttpFoundation\Request;

class PopularityRankingController
{

    /**
     * 人気商品ランキングの商品表示数の設定画面
     *
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Application $app, Request $request)
    {
        
        $Config = $app['popularity_ranking_plugin.repository.config']->findOneBy(array(
            'name' => 'quantity'
        ));
        
        $quantity = $Config->getValue();

        $ProductViewedSums = $app['popularity_ranking_plugin.repository.product_viewed_sum']->findBy(
            array(),
            array(
                "viewed_sum" => "DESC"
            ),
            $quantity
        );
        
        $Products = array();
        
        foreach ($ProductViewedSums as $productViewedSum) {
            $Products[] = $productViewedSum->getProduct();
        }

        return $app->render('Block/popularity_ranking.twig', array(
            'Products' => $Products,
        ));
    }

}

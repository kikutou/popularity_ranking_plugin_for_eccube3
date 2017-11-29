<?php

/*
 * This file is part of the Top
 *
 * Copyright (C) 2017 Lin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\PopularityRanking\Controller;

use Eccube\Application;
use Eccube\Common\Constant;
use Symfony\Component\HttpFoundation\Request;

class ConfigController
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

        $form = $app['form.factory']
            ->createBuilder('popularity_ranking_config')
            ->getForm();
        
        $Config = $app['popularity_ranking_plugin.repository.config']->findOneBy(array(
            'name' => 'quantity'
        ));

        $form[$Config->getName()]->setData($Config->getValue());

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                //設定登録
                $Values = $form->getData();

                $quantity_value = $Values["quantity"];

                $Config->setValue($quantity_value);

                $app['orm.em']->persist($Config);
                $app['orm.em']->flush();

                $app->addSuccess('人気ランキングの表示数を変更しました。', 'admin');
            }
        }

        return $app->render('PopularityRanking/Resource/template/admin/config.twig', array(
            'form' => $form->createView(),
        ));
    }

}

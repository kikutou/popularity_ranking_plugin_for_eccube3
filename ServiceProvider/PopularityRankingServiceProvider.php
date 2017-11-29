<?php

namespace Plugin\PopularityRanking\ServiceProvider;

use Eccube\Application;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;
use Plugin\PopularityRanking\Form\Type\PopularityRankingConfigType;

class PopularityRankingServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
        // Repository
        $app['popularity_ranking_plugin.repository.product_viewed_sum'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\PopularityRanking\Entity\ProductViewedSum');
        });
        $app['popularity_ranking_plugin.repository.config'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\PopularityRanking\Entity\Config');
        });
        
        // Route
        $app->match('/'.$app['config']['admin_route'].'/plugin/popularity_ranking/config', 'Plugin\PopularityRanking\Controller\ConfigController::index')->bind('plugin_popularity_ranking_config');

        
        // Form/Type
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new PopularityRankingConfigType();
            return $types;
        }));
        
        // Block
        $app->match('/block/popularity_ranking', 'Plugin\PopularityRanking\Controller\Block\PopularityRankingController::index')->bind('block_popularity_ranking');

    }
    

    public function boot(BaseApplication $app)
    {
    }
}
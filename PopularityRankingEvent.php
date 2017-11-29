<?php
namespace Plugin\PopularityRanking;

use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Entity\Category;
use Eccube\Event\EventArgs;
use Eccube\Entity\Product;
use Plugin\PopularityRanking\Entity\ProductViewedSum;
use Eccube\Event\TemplateEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class PopularityRankingEvent
{

    /** @var \Eccube\Application $app */
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * フロント画面：商品ページをクリックたびに、商品の閲覧総数をインクリメントする。
     *
     * @param EventArgs $event
     */
    public function add_viewed_times(EventArgs $event)
    {   

        $app = $this->app;

        $aruguments = $event->getarguments();

        $Product = $aruguments['Product'];

        //人気商品のデータを取得
        $ProductViewedSum = $app['popularity_ranking_plugin.repository.product_viewed_sum']->findOneBy(array(
            'Product' => $Product
        ));
        
        if (is_null($ProductViewedSum)) {
            $ProductViewedSum = new ProductViewedSum();
            $ProductViewedSum->setViewedSum(1);
            $ProductViewedSum->setProduct($Product);
        } else {
            $ProductViewedSum->setViewedSum( (int) $ProductViewedSum->getViewedSum() + 1);
        }

        $app['orm.em']->persist($ProductViewedSum);
        $app['orm.em']->flush();

    }



}
<?php
namespace Plugin\PopularityRanking;

use Eccube\Plugin\AbstractPluginManager;
use Eccube\Entity\Master\DeviceType;
use Symfony\Component\Filesystem\Filesystem;

class PluginManager extends AbstractPluginManager
{
    // インストールする時に、
    public function install($config, $app)
    {
        
        $this->migrationSchema($app, __DIR__ . '/Resource/doctrine/migration', $config['code'] );
        
        $file = new Filesystem();
        try {
            $file->copy($app['config']['root_dir']. '/app/Plugin/PopularityRanking/Resource/template/popularity_ranking.twig', $app['config']['block_realdir']. '/popularity_ranking.twig', true);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    // アンインストール時にマイグレーションの「down」メソッドを実行します
    public function uninstall($config, $app)
    {
        $this->migrationSchema($app, __DIR__ . '/Resource/doctrine/migration', $config['code'], 0);
        unlink($app['config']['block_realdir']. '/popularity_ranking.twig');
    }

    // プラグイン有効時に、マイグレーションの「up」メソッドを実行します
    public function enable($config, $app)
    {
        $Block = new \Eccube\Entity\Block();
        $Block->setFileName('popularity_ranking');
        $Block->setName('人気商品ランキング');
        $Block->setLogicFlg(1);
        $Block->setDeletableFlg(0);
        $DeviceType = $app['eccube.repository.master.device_type']
            ->find(DeviceType::DEVICE_TYPE_PC);
        $Block->setDeviceType($DeviceType);

        $app['orm.em']->persist($Block);
        $app['orm.em']->flush();
    }

    // プラグイン無効時に、指定の処理 ( ファイルの削除など ) を実行できます。(今回はなし)
    public function disable($config, $app)
    {
        $Block = $app['eccube.repository.block']->findOneBy(array('file_name' => 'popularity_ranking'));
        if($Block){
             $BlockPositions = $app['orm.em']
            ->getRepository('Eccube\Entity\BlockPosition')
            ->findBy(array('Block' => $Block));
            foreach($BlockPositions as $BlockPosition){
                $app['orm.em']->remove($BlockPosition);
            }
            $app['orm.em']->remove($Block);
            $app['orm.em']->flush();
        }
    }

    // プラグインアップデート時に、指定の処理を実行できます。(今回はなし)
    public function update($config, $app)
    {
    }
}
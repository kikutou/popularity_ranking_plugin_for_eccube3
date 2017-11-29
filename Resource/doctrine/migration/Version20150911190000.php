<?php
/*
* Plugin Name : SalesRanking
*
* Copyright (C) 2015 BraTech Co., Ltd. All Rights Reserved.
* http://www.bratech.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Class Version20150911190000
 * @package DoctrineMigrations
 * プラグイン使用者から、人気商品の表示点数を保存するテーブルである。
 *
 * テーブルの構造は以下となる。
 * フィールド    タイプ     NOT NULL
 * name         text        TRUE
 * value        text        FALSE
 */
class Version20150911190000 extends AbstractMigration
{

    const NAME = 'plg_pop_rank_config';

    public function up(Schema $schema)
    {
        if ($schema->hasTable(self::NAME)) {
            return true;
        }

        $table = $schema->createTable(self::NAME);

        $table->addColumn('pop_rank_config_id', 'integer', array(
            'autoincrement' => true,
        ));

        $table->addColumn('pop_rank_config_key', 'text', array(
            'notnull' => true,
        ));

        $table->addColumn('pop_rank_config_value', 'text', array(
            'notnull' => false,
        ));

        $table->setPrimaryKey(array('pop_rank_config_id'));
        
    }
    
    public function postUp(Schema $schema)
    {
        $app = new \Eccube\Application();
        $app->boot();
        
        $this->connection->insert(self::NAME , array('pop_rank_config_key' => 'quantity', 'pop_rank_config_value' => 5));
    }

    public function down(Schema $schema)
    {
        if (!$schema->hasTable(self::NAME)) {
            return true;
        }
        $schema->dropTable(self::NAME);
    }

}

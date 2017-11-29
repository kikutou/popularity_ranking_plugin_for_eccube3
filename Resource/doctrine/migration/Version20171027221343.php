<?php
namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Eccube\Common\Constant;

/**
 * Class Version20171027221343
 * @package DoctrineMigrations
 * 
 * 各商品の商品画面のレビュー数を記録するテーブルを作成する。
 * テーブルの構造は以下となる。
 * フィールド    タイプ     NOTNULL     AI      FK
 * id           integer     ○         ○
 * product_id   integer     ○                 ○
 * viewed_sum   integer     ○
 * create_date  datetime    ○
 * update_date  datetime    ○
 */
class Version20171027221343 extends AbstractMigration
{

    const NAME = 'plg_pop_rank_product_viewed_sum';

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        if ($schema->hasTable(self::NAME)) {
            return true;
        }

        $table = $schema->createTable(self::NAME);

        $table->addColumn('id', 'integer', array(
            'autoincrement' => true,
        ));

        $table->addColumn('viewed_sum', 'integer', array('NotNull' => true));
        $table->addColumn('product_id', 'integer', array('NotNull' => true));

        $table->addColumn('create_date', 'datetime', array('NotNull' => true));
        $table->addColumn('update_date', 'datetime', array('NotNull' => true));
        $table->setPrimaryKey(array('id'));


        $targetTable = $schema->getTable('dtb_product');
        $table->addForeignKeyConstraint(
            $targetTable,
            array('product_id'),
            array('product_id')
        );

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        if (!$schema->hasTable(self::NAME)) {
            return true;
        }
        $schema->dropTable(self::NAME);

    }
    
//    // 対象のエンティティを指定
//    protected $entities = array(
//        'Plugin\PopularityRanking\Entity\ProductViewedSum',
//    );
//
//    public function up(Schema $schema)
//    {
//        // テーブルの生成
//        $app = \Eccube\Application::getInstance();
//        $meta = $this->getMetadata($app['orm.em']);
//        $tool = new SchemaTool($app['orm.em']);
//        $tool->createSchema($meta);
//    }
//
//    public function down(Schema $schema)
//    {
//        $app = \Eccube\Application::getInstance();
//        $meta = $this->getMetadata($app['orm.em']);
//
//        $tool = new SchemaTool($app['orm.em']);
//        $schemaFromMetadata = $tool->getSchemaFromMetadata($meta);
//
//        // テーブル削除
//        foreach ($schemaFromMetadata->getTables() as $table) {
//            if ($schema->hasTable($table->getName())) {
//                $schema->dropTable($table->getName());
//            }
//        }
//
//        // シーケンス削除
//        foreach ($schemaFromMetadata->getSequences() as $sequence) {
//            if ($schema->hasSequence($sequence->getName())) {
//                $schema->dropSequence($sequence->getName());
//            }
//        }
//    }
//
//    protected function getMetadata(EntityManager $em)
//    {
//        $meta = array();
//        foreach ($this->entities as $entity) {
//            $meta[] = $em->getMetadataFactory()->getMetadataFor($entity);
//        }
//
//        return $meta;
//    }

}

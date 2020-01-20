<?php

use yii\db\Migration;

/**
 * Class m200120_112824_rename_articles_table_to_news
 */
class m200120_112824_rename_articles_table_to_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("RENAME TABLE {{%articles}} TO {{%news}};");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("RENAME TABLE {{%news}} TO {{%articles}};");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200120_112824_rename_articles_table_to_news cannot be reverted.\n";

        return false;
    }
    */
}

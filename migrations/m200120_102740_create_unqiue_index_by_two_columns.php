<?php

use yii\db\Migration;

/**
 * Class m200120_102740_create_unqiue_index_by_two_columns
 */
class m200120_102740_create_unqiue_index_by_two_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE {{%articles}} ADD UNIQUE `unique_index__title_publishedAt`(`title`, `publishedAt`);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("ALTER TABLE {{%articles}} DROP INDEX `unique_index__title_publishedAt`;");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200120_102740_create_unqiue_index_by_two_columns cannot be reverted.\n";

        return false;
    }
    */
}

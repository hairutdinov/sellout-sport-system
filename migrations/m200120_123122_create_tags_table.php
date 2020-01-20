<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tags}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%news}}`
 */
class m200120_123122_create_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull(),
            'name' => $this->string(100),
            'number_of_repetitions' => $this->integer()->defaultValue(1),
        ]);

        // creates index for column `news_id`
        $this->createIndex(
            '{{%idx-tags-news_id}}',
            '{{%tags}}',
            'news_id'
        );

        // add foreign key for table `{{%news}}`
        $this->addForeignKey(
            '{{%fk-tags-news_id}}',
            '{{%tags}}',
            'news_id',
            '{{%news}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%news}}`
        $this->dropForeignKey(
            '{{%fk-tags-news_id}}',
            '{{%tags}}'
        );

        // drops index for column `news_id`
        $this->dropIndex(
            '{{%idx-tags-news_id}}',
            '{{%tags}}'
        );

        $this->dropTable('{{%tags}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m260114_070531_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'is_published' => $this->integer()->defaultValue(0)->notNull(),
            'published_at' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'image' => $this->string()->null()
        ]);


        $this->createIndex('idx_news_is_published', '{{%news}}', 'is_published');
        $this->createIndex('idx_news_published_at', '{{%news}}', 'published_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_news_published_at', '{{%news}}');
        $this->dropIndex('idx_news_is_published', '{{%news}}');

        $this->dropTable('{{%news}}');
    }
}

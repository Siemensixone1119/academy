<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%requests}}`.
 */
class m260114_070639_create_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%requests}}', [
            'id' => $this->primaryKey(),
            'parent_name' => $this->string()->notNull(),
            'child_age' => $this->integer()->notNull(),
            'parent_phone' => $this->string()->notNull(),
            'status' => $this->string()->defaultValue('new')->notNull(),
            'created_at' => $this->integer()->notNull()
        ]);

        $this->createIndex('idx_requests_status', '{{%requests}}', 'status');
        $this->createIndex('idx_requests_created_at', '{{%requests}}', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_requests_created_at', '{{%requests}}');
        $this->dropIndex('idx_requests_status', '{{%requests}}');

        $this->dropTable('{{%requests}}');
    }
}

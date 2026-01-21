<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_users}}`.
 */
class m260114_070650_create_admin_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_users}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->unique()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_users}}');
    }
}

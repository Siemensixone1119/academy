<?php

use yii\db\Migration;

class m260120_073344_create_master_class_schedule extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%master_class}}', [
            'id' => $this->primaryKey(),

            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->null(),

            'age_from' => $this->integer()->null(),
            'age_to' => $this->integer()->null(),

            'starts_at' => $this->dateTime()->notNull(),
            'duration_min' => $this->integer()->null(),

            'price' => $this->integer()->null(), // в рублях, если нужно
            'seats' => $this->integer()->null(),

            'location' => $this->string(255)->null(),

            'is_published' => $this->boolean()->notNull()->defaultValue(1),
            'sort' => $this->integer()->notNull()->defaultValue(500),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-master_class-starts_at', '{{%master_class}}', 'starts_at');
        $this->createIndex('idx-master_class-is_published', '{{%master_class}}', 'is_published');
        $this->createIndex('idx-master_class-sort', '{{%master_class}}', 'sort');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%master_class}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260120_073344_create_master_class_schedule cannot be reverted.\n";

        return false;
    }
    */
}

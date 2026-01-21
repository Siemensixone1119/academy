<?php

use yii\db\Migration;

class m260121_175014_add_auth_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%admin_users}}', 'auth_key', $this->string()->notNull()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%admin_users}}', 'auth_key');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260121_175014_add_auth_key cannot be reverted.\n";

        return false;
    }
    */
}

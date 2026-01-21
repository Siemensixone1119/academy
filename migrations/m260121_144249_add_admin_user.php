<?php

use yii\db\Migration;

class m260121_144249_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO {{%admin_users}} (email, password_hash, created_at) 
                        VALUES ('admin@example.com', '" . Yii::$app->security->generatePasswordHash('oUcKC1nq7ojV') . "', UNIX_TIMESTAMP())");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->execute("DELETE FROM {{%admin_users}} WHERE email = 'admin@example.com'");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260121_144249_add_admin_user cannot be reverted.\n";

        return false;
    }
    */
}

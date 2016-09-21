<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160920_161455_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('user_account', [
            'id' => $this->primaryKey(),
            'username'=>$this->string()->notNull(),
            'password'=>$this->string()->notNull(),
            'account_type'=>$this->string()->notNull(),
            'authkey'=>$this->string(),
            'accesstoken'=>$this->string(),
            'date_joined'=>$this->dateTime(),
            'date_last_update'=>$this->dateTime()
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_account');
    }
}

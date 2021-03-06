<?php

use yii\db\Migration;

class m160921_124440_tbl_ma_claims extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%ma_claims}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'firstname' => $this->string()->notNull(),
            'surname' => $this->string()->notNull(),
            'postcode' => $this->string(),
            'address' => $this->string(),
            'mobile' => $this->float(),
            'tm' => $this->string(),
            'acc_rej' => $this->string(),
            'outcome' => $this->string(),
            'packs_out' => $this->string(),
            'submitted_by' => $this->integer()->notNull(),
            'date_submitted' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%ma_claims}}');
    }
}

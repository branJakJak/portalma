<?php

use yii\db\Migration;

class m160923_103411_add_new_column_comment_money_active_claims extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('{{%ma_claims}}', 'comment', $this->text());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%ma_claims}}', 'comment');
    }
}

<?php

use yii\db\Migration;

class m160923_102622_pb_agent_new_column extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('{{%ma_claims}}', 'pb_agent', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%ma_claims}}', 'pb_agent');
    }
}

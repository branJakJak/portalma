<?php

use yii\db\Migration;

class m160921_131532_add_fk extends Migration
{
    public function up()
    {
        $this->addForeignKey('agent_submission_fk', '{{%ma_claims}}', 'submitted_by', 'user_account', 'id',"CASCADE","CASCADE");
    }

    public function down()
    {
        $this->dropForeignKey("agent_submission_fk", '{{%ma_claims}}');
    }
}
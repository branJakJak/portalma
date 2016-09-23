<?php

use yii\db\Migration;

class m160923_101658_update_mobile_number_field_type extends Migration
{

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->dropColumn('{{%ma_claims}}', 'mobile');
        $this->addColumn('{{%ma_claims}}', 'mobile', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%ma_claims}}', 'mobile');
        $this->addColumn('{{%ma_claims}}', 'mobile', $this->double());        
    }
}

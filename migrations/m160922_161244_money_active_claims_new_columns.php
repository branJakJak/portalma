<?php

use yii\db\Migration;

class m160922_161244_money_active_claims_new_columns extends Migration
{
    public function safeUp()
    {
        $this->addColumn("ma_claims" ,"claim_status",$this->string());
        $this->addColumn("ma_claims", "notes", $this->text());
    }

    public function safeDown()
    {
        $this->dropColumn("ma_claims", "claim_status");
        $this->dropColumn("ma_claims", "notes");
    }
};


<?php

use yii\db\Migration;

class m160923_145417_money_active_claim_add_remaining_cols extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%ma_claims}}', 'date_of_birth', $this->date());
        $this->addColumn('{{%ma_claims}}', 'email', $this->string());
        $this->addColumn('{{%ma_claims}}', 'bank_name', $this->string());
        $this->addColumn('{{%ma_claims}}', 'approx_month', $this->integer());
        $this->addColumn('{{%ma_claims}}', 'approx_date', $this->integer());
        $this->addColumn('{{%ma_claims}}', 'approx_year', $this->integer());
        $this->addColumn('{{%ma_claims}}', 'paid_per_month', $this->float());
        $this->addColumn('{{%ma_claims}}', 'bank_account_type', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%ma_claims}}','date_of_birth');
        $this->dropColumn('{{%ma_claims}}','email');
        $this->dropColumn('{{%ma_claims}}','bank_name');
        $this->dropColumn('{{%ma_claims}}','approx_month');
        $this->dropColumn('{{%ma_claims}}','approx_date');
        $this->dropColumn('{{%ma_claims}}','approx_year');
        $this->dropColumn('{{%ma_claims}}','paid_per_month');
        $this->dropColumn('{{%ma_claims}}','bank_account_type');
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "ma_claims".
 *
 * @property integer $id
 * @property string $title
 * @property string $firstname
 * @property string $surname
 * @property string $postcode
 * @property string $address
 * @property string $mobile
 * @property string $tm
 * @property string $acc_rej
 * @property string $outcome
 * @property string $packs_out
 * @property string $claim_status
 * @property string $notes
 * @property string $comment
 * @property string $pb_agent
 * @property string date_of_birth
 * @property string email
 * @property string bank_name
 * @property integer approx_month
 * @property integer approx_date
 * @property integer approx_year
 * @property integer paid_per_month
 * @property string bank_account_type
 * @property integer $submitted_by
 * @property integer $date_submitted
 * @property integer $updated_at
 *
 * @property UserAccount $submittedBy
 */
class MoneyActiveClaims extends \yii\db\ActiveRecord
{
    const MONEY_ACTIVE_CLAIM_STATUS_PENDING = 'pending';
    const MONEY_ACTIVE_CLAIM_STATUS_DONE = 'done';
    const MONEY_ACTIVE_CLAIM_STATUS_ONGOING = 'ongoing';
    const MONEY_ACTIVE_BANK_ACCOUNT_TYPE_SINGLE = 'single';
    const MONEY_ACTIVE_BANK_ACCOUNT_TYPE_JOINT = 'joint';
    const MONEY_ACTIVE_CLAIM_STATUS_API_IMPORT = 'api_import';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ma_claims';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'firstname', 'surname', 'submitted_by'], 'required'],
            [['approx_month','approx_date','approx_year','paid_per_month','submitted_by'], 'integer'],
            [['title', 'firstname', 'surname', 'postcode', 'address', 'tm', 'acc_rej', 'outcome', 'packs_out' ,'mobile', 'claim_status','pb_agent','date_of_birth','email','bank_name','bank_account_type'], 'string', 'max' => 255],
            [['submitted_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['submitted_by' => 'id']],
        ];
    }
    public function scenarios()
    {
        return [
            'default'=>["id" ,"title","firstname","surname","postcode","address","mobile","tm","acc_rej","outcome","packs_out","claim_status","notes","comment","pb_agent","date_of_birth","email","bank_name","approx_month","approx_date","approx_year","paid_per_month","bank_account_type","submitted_by"],
            self::MONEY_ACTIVE_CLAIM_STATUS_API_IMPORT=>[ "title","firstname","surname","postcode","address","mobile","tm","acc_rej","outcome","packs_out","claim_status","notes","comment","pb_agent","date_of_birth","email","bank_name","approx_month","approx_date","approx_year","paid_per_month","bank_account_type","submitted_by","date_submitted"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'firstname' => 'Firstname',
            'surname' => 'Surname',
            'postcode' => 'Postcode',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'tm' => 'TM',
            'acc_rej' => 'Acc Rej',
            'outcome' => 'Outcome',
            'packs_out' => 'Packs Out',
            'notes' => 'Notes',
            'comment' => 'Comment',
            'claim_status' => 'Claim Status',
            'pb_agent' => 'PB Agent',
            'submitted_by' => 'Submitted By',
            'date_submitted' => 'Date Submitted',
            'updated_at' => 'Updated At',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubmittedBy()
    {
        return $this->hasOne(UserAccount::className(), ['id' => 'submitted_by']);
    }

    public function init()
    {
        if($this->isNewRecord ){
            if (!isset($this->title)) {
                $this->title = "Mr.";
            }
            if (!isset($this->claim_status)) {
                $this->claim_status = self::MONEY_ACTIVE_CLAIM_STATUS_PENDING;
            }
            if ($this->scenario === self::MONEY_ACTIVE_CLAIM_STATUS_API_IMPORT) {
                $this->claim_status = self::MONEY_ACTIVE_CLAIM_STATUS_DONE;
            }
        }
        parent::init();
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            if ($this->scenario === self::MONEY_ACTIVE_CLAIM_STATUS_API_IMPORT) {
                $this->claim_status = self::MONEY_ACTIVE_CLAIM_STATUS_DONE;
            } 
            else {
                $this->date_submitted = date("Y-m-d H:i:s",time());
                $this->updated_at = date("Y-m-d H:i:s",time());
            }
        }
        return parent::beforeSave($insert);
    }


    // public function behaviors()
    // {
    //     return [
    //         [
    //             'class' => TimestampBehavior::className(),
    //             'createdAtAttribute' => 'date_submitted',
    //             'updatedAtAttribute' => 'updated_at',
    //             'value'=>new Expression("NOW()")
    //         ],
    //     ];
    // }


}

<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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
 * @property double $mobile
 * @property string $tm
 * @property string $acc_rej
 * @property string $outcome
 * @property string $packs_out
 * @property integer $submitted_by
 * @property integer $date_submitted
 * @property integer $updated_at
 *
 * @property UserAccount $submittedBy
 */
class MoneyActiveClaims extends \yii\db\ActiveRecord
{
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
            [['mobile'], 'number'],
            [['submitted_by', 'date_submitted', 'updated_at'], 'integer'],
            [['title', 'firstname', 'surname', 'postcode', 'address', 'tm', 'acc_rej', 'outcome', 'packs_out'], 'string', 'max' => 255],
            [['submitted_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['submitted_by' => 'id']],
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
            'tm' => 'Tm',
            'acc_rej' => 'Acc Rej',
            'outcome' => 'Outcome',
            'packs_out' => 'Packs Out',
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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_submitted',
                'updatedAtAttribute' => 'updated_at',
                'value'=>new Expression("NOW()")
            ],
        ];
    }


}

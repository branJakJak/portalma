<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\ModelEvent;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user_account".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $account_type
 * @property string $authkey
 * @property string $accesstoken
 * @property string $date_joined
 * @property string $date_last_update
 */
class UserAccount extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const USER_ACCOUNT_TYPE_ADMIN = 'admin';
    const USER_ACCOUNT_TYPE_AGENT = 'agent';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'unique'],
            [['username', 'password', 'account_type'], 'required'],
            [['date_joined', 'date_last_update'], 'safe'],
            [['username', 'password', 'account_type', 'authkey', 'accesstoken'], 'string', 'max' => 255],
            [['username'], 'unique','on'=>'update'],
            [['username', 'password', 'account_type'], 'required','on'=>'update'],
            [['date_joined', 'date_last_update'], 'safe','on'=>'update'],
            [['username', 'password', 'account_type', 'authkey', 'accesstoken'], 'string', 'max' => 255,'on'=>'update'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'account_type' => 'Account Type',
            'authkey' => 'Authkey',
            'accesstoken' => 'Accesstoken',
            'date_joined' => 'Date Joined',
            'date_last_update' => 'Date Last Update',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @throws \yii\base\Exception
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        $model = UserAccount::find()->where(['id' => $id])->one();
        if (is_null($model) || empty($model)) {
            throw new Exception("$id doesn't exists in the database");
        }
        return $model;
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @throws \yii\base\Exception
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $model = UserAccount::find()->where(['token' => $token]);
        if (is_null($model) || empty($model)) {
            throw new Exception("$token doesn't exists in the database");
        }
        return $model;
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @throws \yii\base\Exception
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @throws \yii\base\Exception
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->authkey;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        $isValid = true;
        $model = UserAccount::find()->where(['id' => $this->authkey]);
        if (is_null($model) || empty($model)) {
            $isValid = false;
        }
        return $isValid;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_joined',
                'updatedAtAttribute' => 'date_last_update',
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord || $this->scenario === 'update') {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }
        return parent::beforeSave($insert);
    }

}

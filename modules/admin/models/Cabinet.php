<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "cabinet".
 *
 * @property int $id
 * @property string|null $role
 * @property string|null $username
 * @property string|null $auth_key
 * @property string|null $password_hash
 * @property string|null $password_reset_token
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Cabinet extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 9;


    public $password;


    public static function tableName()
    {
        return 'cabinet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['role'], 'string', 'max' => 20],
            [['username', 'auth_key', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    /**
     * @return array
     */
    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        return $scenarios;
    }

    /**
     * @return void
     */
    public function beforeDelete()
    {
        $this->status = self::STATUS_DELETED;
        $this->username = $this->username . '_' . $this->id;
        $this->save(false);

    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
//        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        return static::findOne(['auth_key' => $token, 'status' => static::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() ;
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public function can($permissionName, $params = [])
    {
        return Yii::$app->authManager->checkAccess($this->getId(), $permissionName, $params);
    }



    /**
     * @return string[]
     */
    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE => 'Faol',
            self::STATUS_INACTIVE => 'Nofaol',
            self::STATUS_DELETED => "O'chirilgan",
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::statuses(), $this->status, $this->status);
    }

    public static function users()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'username');
    }



    public function getIsDeleted()
    {
        return $this->status == self::STATUS_DELETED;
    }
}

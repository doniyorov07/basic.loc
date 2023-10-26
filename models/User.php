<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read string $authKey
 * @property string $firstname [varchar(255)]
 * @property string $lastname [varchar(255)]



 */
class User extends ActiveRecord implements IdentityInterface
{



    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 9;


    public $password;

    //<editor-fold desc="Parent methods" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'unique', 'message' => 'Ushbu login avvalroq band qilingan.'],
            [['username'], 'required'],
            [['username'], 'string', 'max' => 255],
            ['password', 'string', 'min' => 5],
            ['password', 'trim'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @throws \Exception
     */

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Login',
            'password' => 'Parol',
            'created_at' => "Yaratildi",
            'updated_at' => "Tahrirlandi",
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

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    /**
     * @param string $permissionName
     * @param array $params
     * @return bool
     */
    public function can($permissionName, $params = [])
    {
        return Yii::$app->authManager->checkAccess($this->getId(), $permissionName, $params);
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return $this->firstname . ' ' . $this->lastname;
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

    /**
     * @return mixed|null
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::statuses(), $this->status, $this->status);
    }

    /**
     * @return string
     */
    public function getStatusBadge(): string
    {
        switch ($this->status) {
            case self::STATUS_ACTIVE:
                return '<span class="badge badge-success">Faol</span>';
            case self::STATUS_INACTIVE:
                return '<span class="badge badge-danger">Nofaol</span>';
            case self::STATUS_DELETED:
                return '<span class="badge badge-default">O\'chirilgan</span>';
            default:
                return '<span class="badge badge-default">' . $this->status . '</span>';
        }
    }

    //</editor-fold>

    /**
     * @return array
     */
    public static function users()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'username');
    }


    /**
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->status == self::STATUS_DELETED;
    }
}
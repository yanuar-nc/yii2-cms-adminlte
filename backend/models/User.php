<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\BaseModel;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $row_status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends BaseModel implements IdentityInterface
{

    public static $uploadFile = [
        'image' => [
            'path' => 'users/',
            'using' => 'manually',
            'resize' => [
                [
                    'prefix' => 'thumb_',
                    'size' => [200,200],
                ]
            ]
        ]
    ];

    const ROLE_USER      = 10;
    const ROLE_MODERATOR = 20;
    const ROLE_ADMIN     = 30;
    
    static $role = [ '10' => 'User', '20' => 'Moderator', '30' => 'Admin'];

    public $oldPassword, $newPassword, $rePassword;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ ['username','fullname', 'email', 'password'], 'required' ],
            [ ['fullname', 'position'], 'alphabetsValidation' ],
            [ 'password', 'string', 'min' => 6 ],
            [ ['password', 'newPassword', 'rePassword'], 'passwordValidation' ],
            [ ['oldPassword', 'newPassword', 'rePassword'], 'required', 'on' => 'change-password' ],
            [ ['newPassword', 'rePassword'], 'passwordCompare', 'on' => 'change-password' ],
            [ 'oldPassword', 'oldPasswordValidation', 'on' => 'change-password' ],
            [ 'email', 'filter', 'filter' => 'trim' ],
            [ 'email', 'uniquenessValidation'],
            [ 'email', 'email' ],
            [ 'username', 'characterValidation'],
            [ 'username', 'uniquenessValidation'],
            [ 'role', 'number' ],
            [ 'row_status', 'default', 'value' => self::STATUS_ACTIVE ],
            [ 'row_status', 'in', 'range' => [ -1, 0, 1 ] ],
        ];
    }   

    public function oldPasswordValidation($attribute, $value)
    {
        if ($this->validatePassword($this->oldPassword))
        {
            return true;
        }
        $this->addError( $attribute, 'Your old password is invalid');
        return false;
    }

    public function passwordCompare($attribute)
    {
        if ($this->newPassword !== $this->rePassword)
        {
            $this->addError( $attribute, 'Your new password and re-password is not equal');
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'row_status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->fullname = $this->fullname;
        $user->position = $this->position;
        $user->email    = $this->email;
        $user->username = strtolower($this->username);
        $user->role     = isset($this->role) ? $this->role : self::ROLE_ADMIN ;
        $user->row_status = isset($this->row_status) ? $this->row_status : 1 ;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : false;
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'row_status' => self::STATUS_ACTIVE]);
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
            'row_status' => self::STATUS_ACTIVE,
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

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
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
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
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
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Gets the role
     * .
     * @param role      10|20|30
     * @return     String
     */
    public function getRole()
    {
        $flag = $this->role;
        return self::$role[ $flag ];
    }

    /**
     * Data fields of the form
     *
     * @return     array  ( description of the return value )
     */
    public static function formData()
    {
        return [
            'id',
            'fullname',
            'position',
            'email',
            'username',
            'image' => [
                'fileInput'
            ],
            'password' => [
                'textInput' => [ 'options' => [ 'type' => 'password' ] ]
            ],
            'role' => [
                'dropDownList' => [ 'list' => self::$role ]
            ],
            'row_status' => [
                'dropDownList' => [ 'list' => parent::$getStatus ]
            ]
        ];
    }

    /**
     * Data fields of the form
     *
     * @return     array  ( description of the return value )
     */
    public static function formEditData()
    {
        return [
            'id',
            'fullname',
            'position',
            'email',
            'username',
            'role' => [
                'dropDownList' => [ 'list' => self::$role ]
            ],
            'row_status' => [
                'dropDownList' => [ 'list' => parent::$getStatus ]
            ]
        ];
    }

}

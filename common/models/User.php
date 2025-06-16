<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $personal_id
 * @property string $family_id
 * @property string $auth_key
 * @property string $image
 * @property integer $status
 * @property integer $gender
 * @property string $birth_date
 * @property string $address
 * @property string $phone
 * @property integer $role_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property Employee $employee
 * @property Lecture $lecture

 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['personal_id', 'trim'],
            ['personal_id', 'required'],
            ['personal_id', 'string', 'min' => 5, 'max' => 16],

            ['family_id', 'trim'],
            ['family_id', 'required'],
            ['family_id', 'string', 'min' => 5, 'max' => 16],

            ['gender', 'required'],
            ['gender', 'in', 'range' => [0, 1]],

            ['birth_date', 'required'],
            ['birth_date', 'date', 'format' => 'php:Y-m-d'],

            ['address', 'trim'],

            ['role_id', 'required'],
            ['role_id', 'integer'],

            ['phone', 'required'],
            ['phone', 'string', 'min' => 8, 'max' => 15],
            ['phone', 'match', 'pattern' => '/^(\+62|62|08)[0-9]{7,12}$/', 'message' => 'Format nomor telepon tidak valid. Contoh: +6281234567890 atau 081234567890.'],

            ['birth_date', 'date', 'format' => 'php:Y-m-d'],
            ['birth_date', 'validateBirthDate'],

            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->phone) && str_starts_with($this->phone, '0')) {
                $this->phone = preg_replace('/^0/', '+62', $this->phone);
            }
            return true;
        }
        return false;
    }

    public function validateBirthDate($attribute, $params)
    {
        if (!empty($this->$attribute) && strtotime($this->$attribute) > time()) {
            $this->addError($attribute, 'Tanggal lahir tidak boleh melebihi hari ini.');
        }
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
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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
     * Find user by username or email
     *
     * @param $login
     * @return array|ActiveRecord|null
     */
    public static function findByUsernameOrEmail($login)
    {
        return static::find()
            ->where(['or', ['username' => $login], ['email' => $login]])
            ->andWhere(['status' => self::STATUS_ACTIVE])
            ->one();
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
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
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
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return ($this->role_id === 1);
    }

    /**
     * Check user access
     *
     * @return bool
     */
    public function checkAccess(): bool
    {
        return ($this->role_id === 1) || ($this->role_id === 2) || $this->role_id === 3 || $this->role_id === 4;
    }

    /**
     * Getter password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return '';
    }

    /**
     * Get user employee
     *
     * @return ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['user_id' => 'id']);
    }

    /**
     * Get user lecture via employee
     *
     * @return ActiveQuery
     */
    public function getLecture()
    {
        return $this->hasOne(Lecture::class, ['employee_id' => 'id'])
            ->via('employee');
    }

    /**
     * Get user role
     *
     * @return ActiveQuery
     */
    public function getRole(): ActiveQuery
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    public function getGenderLabel(): string
    {
        return $this->gender == 1 ? 'Laki-laki' : 'Perempuan';
    }

    public function getStatusLabel()
    {
        switch ($this->status) {
            case 10:
                return '<span class="badge badge-pill badge-success">Aktif</span>';
            case 9:
                return '<span class="badge badge-pill badge-warning">Tidak Aktif</span>';
            case 0:
                return '<span class="badge badge-pill badge-danger">Dihapus</span>';
            default:
                return '<span class="badge badge-pill badge-secondary">Tidak Diketahui</span>';
        }
    }


    public function create()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->name = $this->name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        return $user->save() && $this->sendEmail($user);
    }
}

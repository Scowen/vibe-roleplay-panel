<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property integer $questionnaire_passed_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;


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
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['questionnaire_passed_at'], 'integer'],
        ];
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
    public static function findByVerificationToken($token)
    {
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
     * Gets query for [[UserRoles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRole::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Roles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::class, ['id' => 'role_id'])
            ->viaTable('{{%user_role}}', ['user_id' => 'id']);
    }

    /**
     * Check if user has a specific permission
     *
     * @param string $permissionName
     * @return bool
     */
    public function can($permissionName)
    {
        return Yii::$app->permissionChecker->can($permissionName, $this);
    }

    /**
     * Check if user has any of the specified permissions
     *
     * @param array $permissions
     * @return bool
     */
    public function canAny($permissions)
    {
        return Yii::$app->permissionChecker->canAny($permissions, $this);
    }

    /**
     * Check if user has all of the specified permissions
     *
     * @param array $permissions
     * @return bool
     */
    public function canAll($permissions)
    {
        return Yii::$app->permissionChecker->canAll($permissions, $this);
    }

    /**
     * Check if user has a specific role
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRole($roleName)
    {
        return Yii::$app->permissionChecker->hasRole($roleName, $this);
    }

    /**
     * Get user's primary role (first assigned role)
     *
     * @return Role|null
     */
    public function getPrimaryRole()
    {
        $roles = $this->roles;
        return !empty($roles) ? $roles[0] : null;
    }

    /**
     * Assign a role to user
     *
     * @param int $roleId
     * @return bool
     */
    public function assignRole($roleId)
    {
        // Check if role already assigned
        if ($this->hasRole(Role::findOne($roleId)->name)) {
            return true;
        }

        $userRole = new UserRole();
        $userRole->user_id = $this->id;
        $userRole->role_id = $roleId;
        $userRole->created_at = time();

        if ($userRole->save()) {
            Yii::$app->permissionChecker->clearCache($this);
            return true;
        }

        return false;
    }

    /**
     * Remove a role from user
     *
     * @param int $roleId
     * @return bool
     */
    public function removeRole($roleId)
    {
        $deleted = UserRole::deleteAll(['user_id' => $this->id, 'role_id' => $roleId]);

        if ($deleted) {
            Yii::$app->permissionChecker->clearCache($this);
            return true;
        }

        return false;
    }

    /**
     * Check if user has completed questionnaire
     *
     * @return bool
     */
    public function hasCompletedQuestionnaire()
    {
        return !empty($this->questionnaire_passed_at);
    }

    /**
     * Mark questionnaire as completed
     *
     * @return bool
     */
    public function markQuestionnaireCompleted()
    {
        $this->questionnaire_passed_at = time();
        return $this->save(false, ['questionnaire_passed_at', 'updated_at']);
    }
}

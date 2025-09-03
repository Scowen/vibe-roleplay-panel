<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Role model
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property boolean $is_system
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property RolePermission[] $rolePermissions
 * @property Permission[] $permissions
 * @property UserRole[] $userRoles
 * @property User[] $users
 */
class Role extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%role}}';
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
            [['name'], 'required'],
            [['description'], 'string'],
            [['is_system'], 'boolean'],
            [['is_system'], 'default', 'value' => false],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Role name can only contain letters, numbers, underscores and hyphens.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Role Name',
            'description' => 'Description',
            'is_system' => 'System Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[RolePermissions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRolePermissions()
    {
        return $this->hasMany(RolePermission::class, ['role_id' => 'id']);
    }

    /**
     * Gets query for [[Permissions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPermissions()
    {
        return $this->hasMany(Permission::class, ['id' => 'permission_id'])
            ->viaTable('{{%role_permission}}', ['role_id' => 'id']);
    }

    /**
     * Gets query for [[UserRoles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRole::class, ['role_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('{{%user_role}}', ['role_id' => 'id']);
    }

    /**
     * Check if role has a specific permission
     *
     * @param string $permissionName
     * @return bool
     */
    public function hasPermission($permissionName)
    {
        return $this->getPermissions()->where(['name' => $permissionName])->exists();
    }

    /**
     * Get all available roles as array for dropdowns
     *
     * @return array
     */
    public static function getRolesList()
    {
        return ArrayHelper::map(self::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    /**
     * Get system roles
     *
     * @return \yii\db\ActiveQuery
     */
    public static function findSystemRoles()
    {
        return self::find()->where(['is_system' => true]);
    }

    /**
     * Get non-system roles
     *
     * @return \yii\db\ActiveQuery
     */
    public static function findCustomRoles()
    {
        return self::find()->where(['is_system' => false]);
    }

    /**
     * Check if role can be deleted
     *
     * @return bool
     */
    public function canDelete()
    {
        if ($this->is_system) {
            return false;
        }

        // Check if any users have this role
        return !$this->getUsers()->exists();
    }

    /**
     * Get permission names as array
     *
     * @return array
     */
    public function getPermissionNames()
    {
        return ArrayHelper::getColumn($this->permissions, 'name');
    }

    /**
     * Assign permissions to role
     *
     * @param array $permissionIds
     * @return bool
     */
    public function assignPermissions($permissionIds)
    {
        // Remove existing permissions
        RolePermission::deleteAll(['role_id' => $this->id]);

        // Add new permissions
        foreach ($permissionIds as $permissionId) {
            $rolePermission = new RolePermission();
            $rolePermission->role_id = $this->id;
            $rolePermission->permission_id = $permissionId;
            $rolePermission->created_at = time();

            if (!$rolePermission->save()) {
                return false;
            }
        }

        return true;
    }
}

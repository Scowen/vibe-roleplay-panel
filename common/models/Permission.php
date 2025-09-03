<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Permission model
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $category
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property RolePermission[] $rolePermissions
 * @property Role[] $roles
 */
class Permission extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%permission}}';
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
            [['name', 'category'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['category'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Permission name can only contain letters, numbers, underscores and hyphens.'],
            [['category'], 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Category can only contain letters, numbers, underscores and hyphens.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Permission Name',
            'description' => 'Description',
            'category' => 'Category',
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
        return $this->hasMany(RolePermission::class, ['permission_id' => 'id']);
    }

    /**
     * Gets query for [[Roles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::class, ['id' => 'role_id'])
            ->viaTable('{{%role_permission}}', ['permission_id' => 'id']);
    }

    /**
     * Get all available permissions as array for dropdowns
     *
     * @return array
     */
    public static function getPermissionsList()
    {
        return ArrayHelper::map(self::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    /**
     * Get permissions by category
     *
     * @param string $category
     * @return \yii\db\ActiveQuery
     */
    public static function findByCategory($category)
    {
        return self::find()->where(['category' => $category])->orderBy(['name' => SORT_ASC]);
    }

    /**
     * Get all available categories
     *
     * @return array
     */
    public static function getCategories()
    {
        return ArrayHelper::map(
            self::find()->select('category')->distinct()->orderBy(['category' => SORT_ASC])->all(),
            'category',
            'category'
        );
    }

    /**
     * Check if permission exists by name
     *
     * @param string $permissionName
     * @return bool
     */
    public static function exists($permissionName)
    {
        return self::find()->where(['name' => $permissionName])->exists();
    }

    /**
     * Get permission by name
     *
     * @param string $permissionName
     * @return static|null
     */
    public static function findByName($permissionName)
    {
        return self::findOne(['name' => $permissionName]);
    }

    /**
     * Get permissions grouped by category
     *
     * @return array
     */
    public static function getGroupedPermissions()
    {
        $permissions = self::find()->orderBy(['category' => SORT_ASC, 'name' => SORT_ASC])->all();
        $grouped = [];

        foreach ($permissions as $permission) {
            $grouped[$permission->category][] = $permission;
        }

        return $grouped;
    }
}

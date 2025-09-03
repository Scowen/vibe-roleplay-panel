<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\web\User;
use common\models\User as UserModel;
use common\models\Role;
use common\models\Permission;

/**
 * PermissionChecker component for handling role-based access control
 */
class PermissionChecker extends Component
{
    /**
     * @var User the user component
     */
    public $user;

    /**
     * @var array cache for user permissions
     */
    private $_permissionCache = [];

    /**
     * @var array cache for user roles
     */
    private $_roleCache = [];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->user === null) {
            $this->user = Yii::$app->user;
        }
    }

    /**
     * Check if the current user has a specific permission
     *
     * @param string $permissionName
     * @param UserModel|null $user
     * @return bool
     */
    public function can($permissionName, $user = null)
    {
        if ($user === null) {
            $user = $this->user->identity;
        }

        if ($user === null) {
            return false;
        }

        $cacheKey = $user->id . '_' . $permissionName;
        if (isset($this->_permissionCache[$cacheKey])) {
            return $this->_permissionCache[$cacheKey];
        }

        $hasPermission = $this->checkUserPermission($user, $permissionName);
        $this->_permissionCache[$cacheKey] = $hasPermission;

        return $hasPermission;
    }

    /**
     * Check if the current user has any of the specified permissions
     *
     * @param array $permissions
     * @param UserModel|null $user
     * @return bool
     */
    public function canAny($permissions, $user = null)
    {
        foreach ($permissions as $permission) {
            if ($this->can($permission, $user)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if the current user has all of the specified permissions
     *
     * @param array $permissions
     * @param UserModel|null $user
     * @return bool
     */
    public function canAll($permissions, $user = null)
    {
        foreach ($permissions as $permission) {
            if (!$this->can($permission, $user)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if the current user has a specific role
     *
     * @param string $roleName
     * @param UserModel|null $user
     * @return bool
     */
    public function hasRole($roleName, $user = null)
    {
        if ($user === null) {
            $user = $this->user->identity;
        }

        if ($user === null) {
            return false;
        }

        $cacheKey = $user->id . '_role_' . $roleName;
        if (isset($this->_roleCache[$cacheKey])) {
            return $this->_roleCache[$cacheKey];
        }

        $hasRole = $this->checkUserRole($user, $roleName);
        $this->_roleCache[$cacheKey] = $hasRole;

        return $hasRole;
    }

    /**
     * Get all permissions for a user
     *
     * @param UserModel|null $user
     * @return array
     */
    public function getUserPermissions($user = null)
    {
        if ($user === null) {
            $user = $this->user->identity;
        }

        if ($user === null) {
            return [];
        }

        $cacheKey = $user->id . '_permissions';
        if (isset($this->_permissionCache[$cacheKey])) {
            return $this->_permissionCache[$cacheKey];
        }

        $permissions = $this->getUserPermissionsList($user);
        $this->_permissionCache[$cacheKey] = $permissions;

        return $permissions;
    }

    /**
     * Get all roles for a user
     *
     * @param UserModel|null $user
     * @return array
     */
    public function getUserRoles($user = null)
    {
        if ($user === null) {
            $user = $this->user->identity;
        }

        if ($user === null) {
            return [];
        }

        $cacheKey = $user->id . '_roles';
        if (isset($this->_roleCache[$cacheKey])) {
            return $this->_roleCache[$cacheKey];
        }

        $roles = $this->getUserRolesList($user);
        $this->_roleCache[$cacheKey] = $roles;

        return $roles;
    }

    /**
     * Clear permission cache for a user
     *
     * @param UserModel|null $user
     */
    public function clearCache($user = null)
    {
        if ($user === null) {
            $user = $this->user->identity;
        }

        if ($user !== null) {
            $userId = $user->id;
            foreach ($this->_permissionCache as $key => $value) {
                if (strpos($key, $userId . '_') === 0) {
                    unset($this->_permissionCache[$key]);
                }
            }
            foreach ($this->_roleCache as $key => $value) {
                if (strpos($key, $userId . '_') === 0) {
                    unset($this->_roleCache[$key]);
                }
            }
        }
    }

    /**
     * Check if user has a specific permission
     *
     * @param UserModel $user
     * @param string $permissionName
     * @return bool
     */
    private function checkUserPermission($user, $permissionName)
    {
        $userRoles = $this->getUserRoles($user);

        foreach ($userRoles as $role) {
            if ($role->hasPermission($permissionName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has a specific role
     *
     * @param UserModel $user
     * @param string $roleName
     * @return bool
     */
    private function checkUserRole($user, $roleName)
    {
        $userRoles = $this->getUserRoles($user);

        foreach ($userRoles as $role) {
            if ($role->name === $roleName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get user permissions list
     *
     * @param UserModel $user
     * @return array
     */
    private function getUserPermissionsList($user)
    {
        $permissions = [];
        $userRoles = $user->userRoles;

        foreach ($userRoles as $userRole) {
            $role = $userRole->role;
            if ($role) {
                $rolePermissions = $role->permissions;
                foreach ($rolePermissions as $permission) {
                    $permissions[$permission->name] = $permission;
                }
            }
        }

        return array_values($permissions);
    }

    /**
     * Get user roles list
     *
     * @param UserModel $user
     * @return array
     */
    private function getUserRolesList($user)
    {
        $roles = [];
        $userRoles = $user->userRoles;

        foreach ($userRoles as $userRole) {
            $role = $userRole->role;
            if ($role) {
                $roles[] = $role;
            }
        }

        return $roles;
    }

    /**
     * Check if user has completed questionnaire (for basic access)
     *
     * @param UserModel|null $user
     * @return bool
     */
    public function hasCompletedQuestionnaire($user = null)
    {
        if ($user === null) {
            $user = $this->user->identity;
        }

        if ($user === null) {
            return false;
        }

        return !empty($user->questionnaire_passed_at);
    }

    /**
     * Check if user can access panel (has basic permissions and completed questionnaire)
     *
     * @param UserModel|null $user
     * @return bool
     */
    public function canAccessPanel($user = null)
    {
        if ($user === null) {
            $user = $this->user->identity;
        }

        if ($user === null) {
            return false;
        }

        return $this->hasCompletedQuestionnaire($user) && $this->can('view_panel', $user);
    }
}

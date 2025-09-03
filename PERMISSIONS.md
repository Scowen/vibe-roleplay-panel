# Roles and Permissions System

This document describes the comprehensive roles and permissions system implemented in the Vibe Roleplay Panel.

## Overview

The system implements Role-Based Access Control (RBAC) with the following components:

- **Roles**: Groups of permissions that can be assigned to users
- **Permissions**: Individual actions or capabilities within the system
- **User-Role Assignments**: Many-to-many relationships between users and roles
- **Permission Checking**: Methods to verify user capabilities

## Database Structure

### Tables

1. **`role`** - Stores role information
   - `id` - Primary key
   - `name` - Unique role name (e.g., "Member", "Administrator")
   - `description` - Human-readable description
   - `is_system` - Boolean flag for system roles (cannot be deleted)
   - `created_at`, `updated_at` - Timestamps

2. **`permission`** - Stores individual permissions
   - `id` - Primary key
   - `name` - Unique permission name (e.g., "view_panel", "manage_users")
   - `description` - Human-readable description
   - `category` - Grouping for permissions (e.g., "panel", "administration")
   - `created_at`, `updated_at` - Timestamps

3. **`role_permission`** - Junction table for role-permission relationships
   - `id` - Primary key
   - `role_id` - Foreign key to role table
   - `permission_id` - Foreign key to permission table
   - `created_at` - Timestamp

4. **`user_role`** - Junction table for user-role relationships
   - `id` - Primary key
   - `user_id` - Foreign key to user table
   - `role_id` - Foreign key to role table
   - `created_at` - Timestamp

## Default Roles and Permissions

### Member Role (Default)
The Member role is automatically assigned to users who complete the questionnaire and includes:

**Panel Access:**
- `view_panel` - Access to main dashboard
- `view_profile` - View own profile
- `edit_profile` - Edit own profile
- `change_password` - Change own password

**Character Management:**
- `view_own_characters` - View own characters
- `create_character` - Create new characters
- `edit_own_character` - Edit own characters
- `delete_own_character` - Delete own characters

**Questionnaire:**
- `take_questionnaire` - Take the rules questionnaire
- `view_questionnaire_results` - View questionnaire results

**Settings:**
- `view_settings` - View user settings
- `edit_settings` - Edit user settings

### Administrator Role
The Administrator role has access to all permissions in the system, including:

**Role Management:**
- `manage_roles` - Create, edit, and delete roles
- `manage_permissions` - Manage system permissions
- `assign_roles` - Assign roles to users
- `view_user_roles` - View user role assignments

**User Management:**
- `view_users` - View user list
- `edit_users` - Edit user information
- `delete_users` - Delete users
- `ban_users` - Ban/unban users

**System Management:**
- `manage_questionnaire` - Manage questionnaire questions
- `view_system_logs` - View system logs
- `manage_system_settings` - Manage system settings

## Usage

### Checking Permissions in Controllers

```php
// Check if user has a specific permission
if (Yii::$app->permissionChecker->can('manage_users')) {
    // User can manage users
}

// Check if user has any of multiple permissions
if (Yii::$app->permissionChecker->canAny(['edit_users', 'delete_users'])) {
    // User can edit or delete users
}

// Check if user has all permissions
if (Yii::$app->permissionChecker->canAll(['view_users', 'edit_users'])) {
    // User can both view and edit users
}
```

### Checking Permissions in Views

```php
<?php if (Yii::$app->permissionChecker->can('manage_roles')): ?>
    <?= Html::a('Create Role', ['role/create'], ['class' => 'btn btn-success']) ?>
<?php endif; ?>
```

### Using User Model Methods

```php
$user = Yii::$app->user->identity;

// Check specific permission
if ($user->can('edit_profile')) {
    // User can edit profile
}

// Check role
if ($user->hasRole('Administrator')) {
    // User is an administrator
}

// Get user's roles
$roles = $user->roles;

// Get primary role
$primaryRole = $user->getPrimaryRole();
```

### Access Control in Controllers

```php
public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'actions' => ['index', 'view'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->permissionChecker->can('view_users');
                    },
                ],
                [
                    'actions' => ['create', 'update', 'delete'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->permissionChecker->can('manage_users');
                    },
                ],
            ],
        ],
    ];
}
```

## Adding New Permissions

When creating new features, always create corresponding permissions:

1. **Add permission to migration** - Include in the `insertDefaultData()` method
2. **Assign to appropriate roles** - Determine which roles should have access
3. **Use in controllers** - Check permissions before allowing actions
4. **Use in views** - Conditionally show/hide UI elements

### Example: Adding Character Management Permissions

```php
// In migration
['manage_all_characters', 'Manage all characters (admin only)', 'characters'],
['approve_characters', 'Approve character submissions', 'characters'],

// In controller
if (Yii::$app->permissionChecker->can('manage_all_characters')) {
    // Allow managing all characters
}

// In view
<?php if (Yii::$app->permissionChecker->can('approve_characters')): ?>
    <button class="btn btn-success">Approve Character</button>
<?php endif; ?>
```

## Security Considerations

1. **Always check permissions** - Never rely solely on UI hiding for security
2. **Use matchCallback** - For complex permission logic in access control
3. **Validate on server side** - Client-side checks can be bypassed
4. **Cache permissions** - The system includes permission caching for performance
5. **System roles protection** - System roles cannot be deleted or modified

## Performance

The permission system includes caching to minimize database queries:

- **Permission cache** - Caches user permission checks
- **Role cache** - Caches user role information
- **Automatic invalidation** - Cache is cleared when roles are modified

## Migration and Setup

1. **Run migrations** - Execute the role and permission migrations
2. **Assign default roles** - Existing users will get the Member role
3. **Create admin user** - Assign Administrator role to admin users
4. **Test permissions** - Verify the system works as expected

## Troubleshooting

### Common Issues

1. **Permission denied errors** - Check if user has required permissions
2. **Cache issues** - Clear permission cache if roles were modified
3. **Missing permissions** - Ensure permissions exist in database
4. **Role assignment** - Verify users have appropriate roles

### Debug Commands

```php
// Check user permissions
$permissions = Yii::$app->permissionChecker->getUserPermissions();

// Check user roles
$roles = Yii::$app->permissionChecker->getUserRoles();

// Clear cache
Yii::$app->permissionChecker->clearCache();
```

## Best Practices

1. **Principle of least privilege** - Grant minimum permissions necessary
2. **Regular audits** - Review role assignments periodically
3. **Documentation** - Document all permissions and their purposes
4. **Testing** - Test permission system thoroughly
5. **Backup** - Backup role and permission data before major changes

## Future Enhancements

Potential improvements to consider:

1. **Permission inheritance** - Hierarchical permission structure
2. **Time-based permissions** - Temporary access grants
3. **Audit logging** - Track permission changes and usage
4. **API permissions** - Extend to API endpoints
5. **Mobile permissions** - Mobile-specific permission sets

<?php

use yii\db\Migration;

class m250903_200000_create_roles_and_permissions_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Create roles table
        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull()->unique(),
            'description' => $this->text(),
            'is_system' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Create permissions table
        $this->createTable('{{%permission}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull()->unique(),
            'description' => $this->text(),
            'category' => $this->string(64)->notNull()->defaultValue('general'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Create role_permission table (many-to-many relationship)
        $this->createTable('{{%role_permission}}', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer()->notNull(),
            'permission_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Create user_role table (many-to-many relationship)
        $this->createTable('{{%user_role}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'role_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Add foreign keys
        $this->addForeignKey(
            'fk_role_permission_role',
            '{{%role_permission}}',
            'role_id',
            '{{%role}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_role_permission_permission',
            '{{%role_permission}}',
            'permission_id',
            '{{%permission}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_user_role_user',
            '{{%user_role}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_user_role_role',
            '{{%user_role}}',
            'role_id',
            '{{%role}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Create indexes
        $this->createIndex('idx_role_name', '{{%role}}', 'name');
        $this->createIndex('idx_role_system', '{{%role}}', 'is_system');
        $this->createIndex('idx_permission_name', '{{%permission}}', 'name');
        $this->createIndex('idx_permission_category', '{{%permission}}', 'category');
        $this->createIndex('idx_role_permission_role', '{{%role_permission}}', 'role_id');
        $this->createIndex('idx_role_permission_permission', '{{%role_permission}}', 'permission_id');
        $this->createIndex('idx_user_role_user', '{{%user_role}}', 'user_id');
        $this->createIndex('idx_user_role_role', '{{%user_role}}', 'role_id');

        // Insert default role and permissions
        $this->insertDefaultData();
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_role_role', '{{%user_role}}');
        $this->dropForeignKey('fk_user_role_user', '{{%user_role}}');
        $this->dropForeignKey('fk_role_permission_permission', '{{%role_permission}}');
        $this->dropForeignKey('fk_role_permission_role', '{{%role_permission}}');

        $this->dropTable('{{%user_role}}');
        $this->dropTable('{{%role_permission}}');
        $this->dropTable('{{%permission}}');
        $this->dropTable('{{%role}}');
    }

    private function insertDefaultData()
    {
        $timestamp = time();

        // Insert default role
        $this->insert('{{%role}}', [
            'name' => 'Member',
            'description' => 'Default role for registered users who have completed the questionnaire',
            'is_system' => true,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        $memberRoleId = $this->db->getLastInsertID();

        // Insert permissions
        $permissions = [
            // Basic panel access
            ['view_panel', 'View the main panel dashboard', 'panel'],
            ['view_profile', 'View own profile', 'profile'],
            ['edit_profile', 'Edit own profile', 'profile'],
            ['change_password', 'Change own password', 'profile'],

            // Character management
            ['view_characters', 'View character list', 'characters'],
            ['view_own_characters', 'View own characters', 'characters'],
            ['create_character', 'Create new character', 'characters'],
            ['edit_own_character', 'Edit own characters', 'characters'],
            ['delete_own_character', 'Delete own characters', 'characters'],

            // Questionnaire
            ['take_questionnaire', 'Take the rules questionnaire', 'questionnaire'],
            ['view_questionnaire_results', 'View questionnaire results', 'questionnaire'],

            // Settings
            ['view_settings', 'View user settings', 'settings'],
            ['edit_settings', 'Edit user settings', 'settings'],

            // Role and permission management (admin only)
            ['manage_roles', 'Manage user roles', 'administration'],
            ['manage_permissions', 'Manage permissions', 'administration'],
            ['assign_roles', 'Assign roles to users', 'administration'],
            ['view_user_roles', 'View user role assignments', 'administration'],

            // User management (admin only)
            ['view_users', 'View user list', 'administration'],
            ['edit_users', 'Edit user information', 'administration'],
            ['delete_users', 'Delete users', 'administration'],
            ['ban_users', 'Ban/unban users', 'administration'],

            // System management (admin only)
            ['manage_questionnaire', 'Manage questionnaire questions', 'administration'],
            ['view_system_logs', 'View system logs', 'administration'],
            ['manage_system_settings', 'Manage system settings', 'administration'],
        ];

        foreach ($permissions as $permission) {
            $this->insert('{{%permission}}', [
                'name' => $permission[0],
                'description' => $permission[1],
                'category' => $permission[2],
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            $permissionId = $this->db->getLastInsertID();

            // Assign basic permissions to Member role
            if (in_array($permission[0], [
                'view_panel',
                'view_profile',
                'edit_profile',
                'change_password',
                'view_own_characters',
                'create_character',
                'edit_own_character',
                'delete_own_character',
                'take_questionnaire',
                'view_questionnaire_results',
                'view_settings',
                'edit_settings'
            ])) {
                $this->insert('{{%role_permission}}', [
                    'role_id' => $memberRoleId,
                    'permission_id' => $permissionId,
                    'created_at' => $timestamp,
                ]);
            }
        }

        // Create Admin role
        $this->insert('{{%role}}', [
            'name' => 'Administrator',
            'description' => 'Full system administrator with all permissions',
            'is_system' => true,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        $adminRoleId = $this->db->getLastInsertID();

        // Assign all permissions to Admin role
        $allPermissions = $this->db->createCommand('SELECT id FROM {{%permission}}')->queryColumn();
        foreach ($allPermissions as $permissionId) {
            $this->insert('{{%role_permission}}', [
                'role_id' => $adminRoleId,
                'permission_id' => $permissionId,
                'created_at' => $timestamp,
            ]);
        }
    }
}

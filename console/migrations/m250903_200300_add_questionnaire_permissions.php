<?php

use yii\db\Migration;

/**
 * Migration to add additional questionnaire-related permissions
 */
class m250903_200300_add_questionnaire_permissions extends Migration
{
    public function up()
    {
        $timestamp = time();

        // Add new questionnaire permissions
        $permissions = [
            ['view_questionnaire_questions', 'View questionnaire questions list', 'questionnaire'],
            ['create_questionnaire_questions', 'Create new questionnaire questions', 'questionnaire'],
            ['edit_questionnaire_questions', 'Edit existing questionnaire questions', 'questionnaire'],
            ['delete_questionnaire_questions', 'Delete questionnaire questions', 'questionnaire'],
            ['manage_questionnaire_answers', 'Manage questionnaire answers', 'questionnaire'],
            ['reorder_questionnaire_questions', 'Reorder questionnaire questions', 'questionnaire'],
            ['toggle_questionnaire_questions', 'Activate/deactivate questionnaire questions', 'questionnaire'],
        ];

        foreach ($permissions as $permission) {
            $this->insert('{{%permission}}', [
                'name' => $permission[0],
                'description' => $permission[1],
                'category' => $permission[2],
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }

        // Get Administrator role ID
        $adminRoleId = $this->db->createCommand('SELECT id FROM {{%role}} WHERE name = :name', [':name' => 'Administrator'])->queryScalar();

        if ($adminRoleId) {
            // Get all new permission IDs
            $newPermissionIds = $this->db->createCommand('SELECT id FROM {{%permission}} WHERE name IN ("' . implode('","', array_column($permissions, 0)) . '")')->queryColumn();

            // Assign all new permissions to Administrator role
            foreach ($newPermissionIds as $permissionId) {
                $this->insert('{{%role_permission}}', [
                    'role_id' => $adminRoleId,
                    'permission_id' => $permissionId,
                    'created_at' => $timestamp,
                ]);
            }
        }

        echo "Additional questionnaire permissions added successfully.\n";
    }

    public function down()
    {
        // Remove the new permissions
        $permissionNames = [
            'view_questionnaire_questions',
            'create_questionnaire_questions',
            'edit_questionnaire_questions',
            'delete_questionnaire_questions',
            'manage_questionnaire_answers',
            'reorder_questionnaire_questions',
            'toggle_questionnaire_questions',
        ];

        foreach ($permissionNames as $permissionName) {
            $this->delete('{{%permission}}', ['name' => $permissionName]);
        }

        echo "Additional questionnaire permissions removed successfully.\n";
    }
}

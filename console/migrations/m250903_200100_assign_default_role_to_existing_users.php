<?php

use yii\db\Migration;

class m250903_200100_assign_default_role_to_existing_users extends Migration
{
    public function up()
    {
        // Get the Member role ID
        $memberRoleId = $this->db->createCommand('SELECT id FROM {{%role}} WHERE name = :name', [':name' => 'Member'])->queryScalar();

        if ($memberRoleId) {
            // Get all existing users
            $users = $this->db->createCommand('SELECT id FROM {{%user}} WHERE status = :status', [':status' => 10])->queryColumn();

            foreach ($users as $userId) {
                // Check if user already has a role
                $existingRole = $this->db->createCommand('SELECT id FROM {{%user_role}} WHERE user_id = :user_id', [':user_id' => $userId])->queryScalar();

                if (!$existingRole) {
                    // Assign Member role to user
                    $this->insert('{{%user_role}}', [
                        'user_id' => $userId,
                        'role_id' => $memberRoleId,
                        'created_at' => time(),
                    ]);
                }
            }
        }
    }

    public function down()
    {
        // Remove Member role from all users
        $memberRoleId = $this->db->createCommand('SELECT id FROM {{%role}} WHERE name = :name', [':name' => 'Member'])->queryScalar();

        if ($memberRoleId) {
            $this->delete('{{%user_role}}', ['role_id' => $memberRoleId]);
        }
    }
}

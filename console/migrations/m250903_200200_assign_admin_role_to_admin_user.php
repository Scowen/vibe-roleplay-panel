<?php

use yii\db\Migration;

class m250903_200200_assign_admin_role_to_admin_user extends Migration
{
    public function up()
    {
        // Get the Administrator role ID
        $adminRoleId = $this->db->createCommand('SELECT id FROM {{%role}} WHERE name = :name', [':name' => 'Administrator'])->queryScalar();

        if ($adminRoleId) {
            // Find the admin user
            $adminUserId = $this->db->createCommand('SELECT id FROM {{%user}} WHERE username = :username', [':username' => 'admin'])->queryScalar();

            if ($adminUserId) {
                // Check if admin user already has a role
                $existingRole = $this->db->createCommand('SELECT id FROM {{%user_role}} WHERE user_id = :user_id', [':user_id' => $adminUserId])->queryScalar();

                if (!$existingRole) {
                    // Assign Administrator role to admin user
                    $this->insert('{{%user_role}}', [
                        'user_id' => $adminUserId,
                        'role_id' => $adminRoleId,
                        'created_at' => time(),
                    ]);

                    echo "Administrator role assigned to admin user successfully.\n";
                } else {
                    echo "Admin user already has a role assigned.\n";
                }
            } else {
                echo "Warning: User 'admin' not found. Please create the admin user first.\n";
            }
        } else {
            echo "Warning: Administrator role not found. Please run the roles migration first.\n";
        }
    }

    public function down()
    {
        // Get the Administrator role ID
        $adminRoleId = $this->db->createCommand('SELECT id FROM {{%role}} WHERE name = :name', [':name' => 'Administrator'])->queryScalar();

        if ($adminRoleId) {
            // Find the admin user
            $adminUserId = $this->db->createCommand('SELECT id FROM {{%user}} WHERE username = :username', [':username' => 'admin'])->queryScalar();

            if ($adminUserId) {
                // Remove Administrator role from admin user
                $this->delete('{{%user_role}}', [
                    'user_id' => $adminUserId,
                    'role_id' => $adminRoleId,
                ]);

                echo "Administrator role removed from admin user successfully.\n";
            }
        }
    }
}

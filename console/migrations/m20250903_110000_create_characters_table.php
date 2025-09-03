<?php

use yii\db\Migration;

class m20250903_110000_create_characters_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%characters}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(100)->notNull(),
            'location_x' => $this->decimal(10, 4)->notNull()->defaultValue(0),
            'location_y' => $this->decimal(10, 4)->notNull()->defaultValue(0),
            'location_z' => $this->decimal(10, 4)->notNull()->defaultValue(0),
            'pitch' => $this->decimal(7, 3)->notNull()->defaultValue(0),
            'yaw' => $this->decimal(7, 3)->notNull()->defaultValue(0),
            'status' => $this->string(16)->notNull()->defaultValue('active'), // active, inactive
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'date_of_birth' => $this->date()->notNull(),
            'money_cash' => $this->bigInteger()->notNull()->defaultValue(0),
            'money_bank' => $this->bigInteger()->notNull()->defaultValue(0),
            'model_id' => $this->integer()->null(),
            'health' => $this->tinyInteger()->notNull()->defaultValue(100),
            'armor' => $this->tinyInteger()->notNull()->defaultValue(0),
            'last_login_at' => $this->integer()->null(),
            'metadata' => $this->text()->null(), // JSON-encoded miscellaneous attributes
        ], $tableOptions);

        // Indexes
        $this->createIndex('idx-characters-user_id', '{{%characters}}', 'user_id');
        $this->createIndex('idx-characters-status', '{{%characters}}', 'status');
        $this->createIndex('idx-characters-name', '{{%characters}}', 'name');

        // Foreign keys
        $this->addForeignKey(
            'fk-characters-user_id',
            '{{%characters}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-characters-user_id', '{{%characters}}');
        $this->dropTable('{{%characters}}');
    }
}
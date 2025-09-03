<?php

use yii\db\Migration;

class m20250903_100000_create_questionnaire_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Create questionnaire_question table
        $this->createTable('{{%questionnaire_question}}', [
            'id' => $this->primaryKey(),
            'question_text' => $this->text()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'sort_order' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Create questionnaire_answer table
        $this->createTable('{{%questionnaire_answer}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'answer_text' => $this->string()->notNull(),
            'is_correct' => $this->boolean()->notNull()->defaultValue(false),
            'sort_order' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);

        // FKs
        $this->addForeignKey(
            'fk_questionnaire_answer_question',
            '{{%questionnaire_answer}}',
            'question_id',
            '{{%questionnaire_question}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Add user field to mark when questionnaire was passed
        $this->addColumn('{{%user}}', 'questionnaire_passed_at', $this->integer()->null()->defaultValue(null));

        // Indexes
        $this->createIndex('idx_questionnaire_question_active', '{{%questionnaire_question}}', 'is_active');
        $this->createIndex('idx_questionnaire_question_sort', '{{%questionnaire_question}}', 'sort_order');
        $this->createIndex('idx_questionnaire_answer_question', '{{%questionnaire_answer}}', 'question_id');
        $this->createIndex('idx_questionnaire_answer_sort', '{{%questionnaire_answer}}', 'sort_order');
        $this->createIndex('idx_user_questionnaire_passed_at', '{{%user}}', 'questionnaire_passed_at');
    }

    public function down()
    {
        $this->dropForeignKey('fk_questionnaire_answer_question', '{{%questionnaire_answer}}');
        $this->dropTable('{{%questionnaire_answer}}');
        $this->dropTable('{{%questionnaire_question}}');
        $this->dropColumn('{{%user}}', 'questionnaire_passed_at');
    }
}
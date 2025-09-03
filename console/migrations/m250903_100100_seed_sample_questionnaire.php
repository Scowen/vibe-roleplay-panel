<?php

use yii\db\Migration;

class m250903_100100_seed_sample_questionnaire extends Migration
{
    public function up()
    {
        // Sample Questions
        $this->insert('{{%questionnaire_question}}', [
            'question_text' => 'What is required to follow when playing on the server?',
            'is_active' => 1,
            'sort_order' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $question1Id = $this->db->getLastInsertID();

        $this->batchInsert('{{%questionnaire_answer}}', ['question_id', 'answer_text', 'is_correct', 'sort_order'], [
            [$question1Id, 'Server rules and guidelines', 1, 10],
            [$question1Id, 'Only rules you personally agree with', 0, 20],
            [$question1Id, 'No rules at all', 0, 30],
        ]);

        $this->insert('{{%questionnaire_question}}', [
            'question_text' => 'What should you do if you witness a rule violation?',
            'is_active' => 1,
            'sort_order' => 20,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $question2Id = $this->db->getLastInsertID();

        $this->batchInsert('{{%questionnaire_answer}}', ['question_id', 'answer_text', 'is_correct', 'sort_order'], [
            [$question2Id, 'Report it via the official channels', 1, 10],
            [$question2Id, 'Retaliate immediately in-game', 0, 20],
            [$question2Id, 'Encourage others to do the same', 0, 30],
        ]);
    }

    public function down()
    {
        // Remove the inserted sample data
        $questionIds = (new \yii\db\Query())
            ->select('id')
            ->from('{{%questionnaire_question}}')
            ->where(['question_text' => [
                'What is required to follow when playing on the server?',
                'What should you do if you witness a rule violation?',
            ]])
            ->column($this->db);

        if (!empty($questionIds)) {
            $this->delete('{{%questionnaire_answer}}', ['question_id' => $questionIds]);
            $this->delete('{{%questionnaire_question}}', ['id' => $questionIds]);
        }
    }
}

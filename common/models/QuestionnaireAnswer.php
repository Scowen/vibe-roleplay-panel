<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $question_id
 * @property string $answer_text
 * @property int $is_correct
 * @property int $sort_order
 *
 * @property QuestionnaireQuestion $question
 */
class QuestionnaireAnswer extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%questionnaire_answer}}';
    }

    public function rules()
    {
        return [
            [['question_id', 'answer_text'], 'required'],
            [['question_id', 'sort_order'], 'integer'],
            [['is_correct'], 'boolean'],
            [['answer_text'], 'string', 'max' => 255],
        ];
    }

    public function getQuestion(): ActiveQuery
    {
        return $this->hasOne(QuestionnaireQuestion::class, ['id' => 'question_id']);
    }
}
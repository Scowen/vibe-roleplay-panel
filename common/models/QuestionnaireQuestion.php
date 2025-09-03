<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $question_text
 * @property int $is_active
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property QuestionnaireAnswer[] $answers
 */
class QuestionnaireQuestion extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%questionnaire_question}}';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    public function rules()
    {
        return [
            [['question_text'], 'required'],
            [['question_text'], 'string'],
            [['is_active'], 'boolean'],
            [['sort_order', 'created_at', 'updated_at'], 'integer'],
            ['sort_order', 'default', 'value' => 0],
            ['is_active', 'default', 'value' => 1],
        ];
    }

    public function getAnswers(): ActiveQuery
    {
        return $this->hasMany(QuestionnaireAnswer::class, ['question_id' => 'id'])->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC]);
    }

    public static function findActiveOrdered(): array
    {
        return static::find()
            ->where(['is_active' => 1])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->with('answers')
            ->all();
    }
}
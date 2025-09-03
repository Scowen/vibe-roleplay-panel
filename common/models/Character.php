<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Character ActiveRecord model
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property float $location_x
 * @property float $location_y
 * @property float $location_z
 * @property float $pitch
 * @property float $yaw
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $date_of_birth
 * @property int $money_cash
 * @property int $money_bank
 * @property int|null $model_id
 * @property int $health
 * @property int|null $last_login_at
 * @property string|null $metadata
 */
class Character extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%characters}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'name', 'date_of_birth'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'money_cash', 'money_bank', 'model_id', 'health', 'last_login_at'], 'integer'],
            [['location_x', 'location_y', 'location_z'], 'number'],
            [['pitch', 'yaw'], 'number'],
            [['date_of_birth'], 'date', 'format' => 'php:Y-m-d'],
            [['status'], 'in', 'range' => ['active', 'inactive']],
            [['name'], 'string', 'max' => 100],
            [['metadata'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'name' => 'Name',
            'location_x' => 'Location X',
            'location_y' => 'Location Y',
            'location_z' => 'Location Z',
            'pitch' => 'Pitch',
            'yaw' => 'Yaw',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'date_of_birth' => 'Date of Birth',
            'money_cash' => 'Cash',
            'money_bank' => 'Bank',
            'model_id' => 'Model ID',
            'health' => 'Health',
            'last_login_at' => 'Last Login',
            'metadata' => 'Metadata',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
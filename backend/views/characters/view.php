<?php

/** @var $this yii\web\View */
/** @var $model common\models\Character */

use yii\bootstrap5\Html;
use yii\widgets\DetailView;

$this->title = Html::encode($model->name);
?>

<div class="character-view">
    <h2 style="margin-bottom: 1rem;">Character: <?= Html::encode($model->name) ?></h2>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'status',
            [
                'attribute' => 'date_of_birth',
                'format' => ['date', 'php:M d, Y'],
            ],
            [
                'label' => 'Location',
                'value' => $model->location_x . ', ' . $model->location_y . ', ' . $model->location_z,
            ],
            'pitch',
            'yaw',
            'health',
            'model_id',
            [
                'attribute' => 'money_cash',
                'label' => 'Cash',
                'format' => ['currency'],
            ],
            [
                'attribute' => 'money_bank',
                'label' => 'Bank',
                'format' => ['currency'],
            ],
            [
                'attribute' => 'last_login_at',
                'format' => ['datetime', 'php:M d, Y g:i A'],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:M d, Y g:i A'],
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['datetime', 'php:M d, Y g:i A'],
            ],
            'metadata:ntext',
        ],
    ]); ?>

    <p>
        <?= Html::a('Back to list', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>
</div>
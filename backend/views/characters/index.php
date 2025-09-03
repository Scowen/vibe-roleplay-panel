<?php

/** @var $this yii\web\View */
/** @var $dataProvider yii\data\ActiveDataProvider */

use yii\bootstrap5\Html;
use yii\grid\GridView;

$this->title = 'My Characters';
?>

<div class="characters-index">
    <h2 style="margin-bottom: 1rem;">My Characters</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'status',
            [
                'attribute' => 'date_of_birth',
                'format' => ['date', 'php:M d, Y'],
            ],
            [
                'label' => 'Location',
                'value' => function ($model) {
                    return $model->location_x . ', ' . $model->location_y . ', ' . $model->location_z;
                }
            ],
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
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:M d, Y g:i A'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return ['characters/' . $action, 'id' => $model->id];
                },
            ],
        ],
    ]); ?>
</div>
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Alert;

/** @var yii\web\View $this */
/** @var common\models\QuestionnaireQuestion $question */

$this->title = 'Question: ' . Html::encode($question->question_text);
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="questionnaire-view">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?php if (Yii::$app->permissionChecker->can('edit_questionnaire_questions')): ?>
                <?= Html::a('<i class="fas fa-edit"></i> Edit', ['update', 'id' => $question->id], ['class' => 'btn btn-warning']) ?>
            <?php endif; ?>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Back to Questions', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <?= Alert::widget([
            'body' => Yii::$app->session->getFlash('success'),
            'options' => ['class' => 'alert-success'],
        ]) ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <!-- Question Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-question-circle"></i> Question Details
                    </h5>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $question,
                        'attributes' => [
                            'id',
                            'question_text:ntext',
                            [
                                'attribute' => 'is_active',
                                'value' => $question->is_active ?
                                    '<span class="badge bg-success">Active</span>' :
                                    '<span class="badge bg-secondary">Inactive</span>',
                                'format' => 'raw',
                            ],
                            'sort_order',
                            [
                                'attribute' => 'created_at',
                                'value' => Yii::$app->formatter->asDatetime($question->created_at),
                            ],
                            [
                                'attribute' => 'updated_at',
                                'value' => Yii::$app->formatter->asDatetime($question->updated_at),
                            ],
                        ],
                        'options' => ['class' => 'table table-striped table-bordered detail-view'],
                    ]) ?>
                </div>
            </div>

            <!-- Answers -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list-check"></i> Answers (<?= count($question->answers) ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($question->answers)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle fa-2x text-muted mb-3"></i>
                            <p class="text-muted">No answers have been created for this question.</p>
                            <?php if (Yii::$app->permissionChecker->can('edit_questionnaire_questions')): ?>
                                <?= Html::a('Add Answers', ['update', 'id' => $question->id], ['class' => 'btn btn-primary']) ?>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Answer</th>
                                        <th style="width: 100px;">Correct</th>
                                        <th style="width: 100px;">Order</th>
                                        <?php if (Yii::$app->permissionChecker->can('edit_questionnaire_questions') || Yii::$app->permissionChecker->can('manage_questionnaire_answers')): ?>
                                            <th style="width: 100px;">Actions</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($question->answers as $index => $answer): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <div class="answer-text">
                                                    <?= Html::encode($answer->answer_text) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($answer->is_correct): ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check"></i> Correct
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-light text-dark">Incorrect</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="text-muted"><?= $answer->sort_order ?></span>
                                            </td>
                                            <?php if (Yii::$app->permissionChecker->can('edit_questionnaire_questions') || Yii::$app->permissionChecker->can('manage_questionnaire_answers')): ?>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <?php if (Yii::$app->permissionChecker->can('edit_questionnaire_questions')): ?>
                                                            <?= Html::a(
                                                                '<i class="fas fa-edit"></i>',
                                                                ['update', 'id' => $question->id],
                                                                [
                                                                    'class' => 'btn btn-sm btn-outline-warning',
                                                                    'title' => 'Edit Answer',
                                                                ]
                                                            ) ?>
                                                        <?php endif; ?>
                                                        <?php if (Yii::$app->permissionChecker->can('manage_questionnaire_answers')): ?>
                                                            <?= Html::a(
                                                                '<i class="fas fa-trash"></i>',
                                                                ['delete-answer', 'id' => $answer->id],
                                                                [
                                                                    'class' => 'btn btn-sm btn-outline-danger',
                                                                    'title' => 'Delete Answer',
                                                                    'data' => [
                                                                        'method' => 'post',
                                                                        'confirm' => 'Are you sure you want to delete this answer? This action cannot be undone.',
                                                                    ],
                                                                ]
                                                            ) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <?php if (Yii::$app->permissionChecker->can('edit_questionnaire_questions')): ?>
                            <?= Html::a(
                                '<i class="fas fa-edit"></i> Edit Question',
                                ['update', 'id' => $question->id],
                                ['class' => 'btn btn-warning']
                            ) ?>
                        <?php endif; ?>

                        <?php if (Yii::$app->permissionChecker->can('toggle_questionnaire_questions')): ?>
                            <?= Html::a(
                                $question->is_active ? '<i class="fas fa-pause"></i> Deactivate' : '<i class="fas fa-play"></i> Activate',
                                ['toggle-question', 'id' => $question->id],
                                [
                                    'class' => 'btn btn-secondary',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => $question->is_active
                                            ? 'Are you sure you want to deactivate this question?'
                                            : 'Are you sure you want to activate this question?',
                                    ],
                                ]
                            ) ?>
                        <?php endif; ?>

                        <?php if (Yii::$app->permissionChecker->can('delete_questionnaire_questions')): ?>
                            <?= Html::a(
                                '<i class="fas fa-trash"></i> Delete Question',
                                ['delete', 'id' => $question->id],
                                [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'Are you sure you want to delete this question? This action cannot be undone.',
                                    ],
                                ]
                            ) ?>
                        <?php endif; ?>

                        <?= Html::a(
                            '<i class="fas fa-plus"></i> Create New Question',
                            ['create'],
                            ['class' => 'btn btn-success']
                        ) ?>
                    </div>
                </div>
            </div>

            <!-- Question Statistics -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar"></i> Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-value text-primary"><?= count($question->answers) ?></div>
                                <div class="stat-label text-muted">Total Answers</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-value text-success">
                                    <?= count(array_filter($question->answers, function ($a) {
                                        return $a->is_correct;
                                    })) ?>
                                </div>
                                <div class="stat-label text-muted">Correct</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="text-center">
                        <div class="stat-item">
                            <div class="stat-value text-info"><?= $question->sort_order ?></div>
                            <div class="stat-label text-muted">Display Order</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-item {
        padding: 1rem 0;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .answer-text {
        font-weight: 500;
    }

    .detail-view th {
        width: 30%;
    }
</style>
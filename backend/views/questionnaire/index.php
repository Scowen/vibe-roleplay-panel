<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap5\Alert;

/** @var yii\web\View $this */
/** @var common\models\QuestionnaireQuestion[] $questions */

$this->title = 'Questionnaire Management';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="questionnaire-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php if (Yii::$app->permissionChecker->can('create_questionnaire_questions')): ?>
            <?= Html::a('<i class="fas fa-plus"></i> Add Question', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <?= Alert::widget([
            'body' => Yii::$app->session->getFlash('success'),
            'options' => ['class' => 'alert-success'],
        ]) ?>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <?= Alert::widget([
            'body' => Yii::$app->session->getFlash('error'),
            'options' => ['class' => 'alert-danger'],
        ]) ?>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Questions</h5>
        </div>
        <div class="card-body">
            <?php if (empty($questions)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No questions have been created yet.</p>
                    <?php if (Yii::$app->permissionChecker->can('create_questionnaire_questions')): ?>
                        <?= Html::a('Create First Question', ['create'], ['class' => 'btn btn-primary']) ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 60px;">Status</th>
                                <th>Question</th>
                                <th style="width: 120px;">Answers</th>
                                <th style="width: 100px;">Order</th>
                                <th style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-questions">
                            <?php foreach ($questions as $index => $question): ?>
                                <tr data-question-id="<?= $question->id ?>">
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <?php if ($question->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="question-text">
                                            <?= Html::encode($question->question_text) ?>
                                        </div>
                                        <?php if (!empty($question->answers)): ?>
                                            <div class="answers-preview mt-2">
                                                <small class="text-muted">Answers:</small>
                                                <div class="d-flex flex-wrap gap-1 mt-1">
                                                    <?php foreach ($question->answers as $answer): ?>
                                                        <span class="badge <?= $answer->is_correct ? 'bg-success' : 'bg-light text-dark' ?>">
                                                            <?= Html::encode($answer->answer_text) ?>
                                                            <?php if ($answer->is_correct): ?>
                                                                <i class="fas fa-check ms-1"></i>
                                                            <?php endif; ?>
                                                        </span>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?= count($question->answers) ?></span>
                                    </td>
                                    <td>
                                        <span class="text-muted"><?= $question->sort_order ?></span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <?= Html::a(
                                                '<i class="fas fa-eye"></i>',
                                                ['view', 'id' => $question->id],
                                                [
                                                    'class' => 'btn btn-sm btn-outline-primary',
                                                    'title' => 'View',
                                                ]
                                            ) ?>

                                            <?php if (Yii::$app->permissionChecker->can('edit_questionnaire_questions')): ?>
                                                <?= Html::a(
                                                    '<i class="fas fa-edit"></i>',
                                                    ['update', 'id' => $question->id],
                                                    [
                                                        'class' => 'btn btn-sm btn-outline-warning',
                                                        'title' => 'Edit',
                                                    ]
                                                ) ?>
                                            <?php endif; ?>

                                            <?php if (Yii::$app->permissionChecker->can('toggle_questionnaire_questions')): ?>
                                                <?= Html::a(
                                                    $question->is_active ? '<i class="fas fa-pause"></i>' : '<i class="fas fa-play"></i>',
                                                    ['toggle-question', 'id' => $question->id],
                                                    [
                                                        'class' => 'btn btn-sm btn-outline-secondary',
                                                        'title' => $question->is_active ? 'Deactivate' : 'Activate',
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
                                                    '<i class="fas fa-trash"></i>',
                                                    ['delete', 'id' => $question->id],
                                                    [
                                                        'class' => 'btn btn-sm btn-outline-danger',
                                                        'title' => 'Delete',
                                                        'data' => [
                                                            'method' => 'post',
                                                            'confirm' => 'Are you sure you want to delete this question? This action cannot be undone.',
                                                        ],
                                                    ]
                                                ) ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (Yii::$app->permissionChecker->can('manage_questionnaire')): ?>
                    <div class="mt-3">
                        <button type="button" class="btn btn-outline-primary" id="save-order">
                            <i class="fas fa-save"></i> Save Order
                        </button>
                        <small class="text-muted ms-2">Drag and drop questions to reorder them</small>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (Yii::$app->permissionChecker->can('reorder_questionnaire_questions') && !empty($questions)): ?>
    <?php
    $this->registerJs("
        // Initialize sortable functionality
        $(function() {
            $('#sortable-questions').sortable({
                handle: 'td:first-child',
                axis: 'y',
                cursor: 'move',
                opacity: 0.6,
                update: function(event, ui) {
                    // Update row numbers
                    $('#sortable-questions tr').each(function(index) {
                        $(this).find('td:first-child').text(index + 1);
                    });
                }
            });
            
            // Save order functionality
            $('#save-order').click(function() {
                var order = [];
                $('#sortable-questions tr').each(function(index) {
                    order.push($(this).data('question-id'));
                });
                
                $.post('" . Url::to(['reorder']) . "', {order: order})
                    .done(function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Failed to save order');
                        }
                    })
                    .fail(function() {
                        alert('Failed to save order');
                    });
            });
        });
    ");
    ?>
<?php endif; ?>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Alert;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\QuestionnaireQuestion $question */
/** @var common\models\QuestionnaireAnswer[] $answers */

$this->title = 'Update Question: ' . Html::encode($question->question_text);
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'View Question', 'url' => ['view', 'id' => $question->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="questionnaire-update">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="fas fa-eye"></i> View', ['view', 'id' => $question->id], ['class' => 'btn btn-info']) ?>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Back to Questions', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <?= Alert::widget([
            'body' => Yii::$app->session->getFlash('error'),
            'options' => ['class' => 'alert-danger'],
        ]) ?>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Question Details</h5>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'questionnaire-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => true,
                'validationUrl' => Url::to(['validate']),
            ]); ?>

            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($question, 'question_text')->textarea([
                        'rows' => 4,
                        'placeholder' => 'Enter your question here...'
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($question, 'is_active')->checkbox([
                                'label' => 'Active',
                                'labelOptions' => ['class' => 'form-check-label'],
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($question, 'sort_order')->textInput([
                                'type' => 'number',
                                'min' => 0,
                                'placeholder' => '0'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="answers-section">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Answers</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-answer">
                        <i class="fas fa-plus"></i> Add Answer
                    </button>
                </div>

                <div id="answers-container">
                    <?php foreach ($answers as $index => $answer): ?>
                        <div class="answer-item border rounded p-3 mb-3" data-index="<?= $index ?>">
                            <div class="row">
                                <div class="col-md-8">
                                    <?= $form->field($answer, "[{$index}]answer_text")->textInput([
                                        'placeholder' => 'Enter answer option...',
                                        'class' => 'form-control'
                                    ])->label(false) ?>
                                    <?= $form->field($answer, "[{$index}]id")->hiddenInput()->label(false) ?>
                                </div>
                                <div class="col-md-2">
                                    <?= $form->field($answer, "[{$index}]is_correct")->checkbox([
                                        'label' => 'Correct',
                                        'labelOptions' => ['class' => 'form-check-label'],
                                        'class' => 'form-check-input'
                                    ]) ?>
                                </div>
                                <div class="col-md-2">
                                    <?= $form->field($answer, "[{$index}]sort_order")->textInput([
                                        'type' => 'number',
                                        'min' => 0,
                                        'placeholder' => '0',
                                        'class' => 'form-control'
                                    ])->label(false) ?>
                                </div>
                            </div>
                            <?php if (count($answers) > 1): ?>
                                <div class="text-end mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-answer">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Note:</strong> At least one answer must be marked as correct. You can reorder answers using the sort order field.
                </div>
            </div>

            <hr class="my-4">

            <div class="form-group text-end">
                <?= Html::submitButton('<i class="fas fa-save"></i> Update Question', [
                    'class' => 'btn btn-success btn-lg',
                    'id' => 'submit-btn'
                ]) ?>
                <?= Html::a('<i class="fas fa-times"></i> Cancel', ['view', 'id' => $question->id], [
                    'class' => 'btn btn-secondary btn-lg ms-2'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$answerTemplate = Html::encode('
    <div class="answer-item border rounded p-3 mb-3" data-index="{index}">
        <div class="row">
            <div class="col-md-8">
                <input type="text" name="QuestionnaireAnswer[{index}][answer_text]" class="form-control" placeholder="Enter answer option...">
                <input type="hidden" name="QuestionnaireAnswer[{index}][id]" value="">
            </div>
            <div class="col-md-2">
                <div class="form-check">
                    <input type="checkbox" name="QuestionnaireAnswer[{index}][is_correct]" class="form-check-input" value="1">
                    <label class="form-check-label">Correct</label>
                </div>
            </div>
            <div class="col-md-2">
                <input type="number" name="QuestionnaireAnswer[{index}][sort_order]" class="form-control" min="0" placeholder="0">
            </div>
        </div>
        <div class="text-end mt-2">
            <button type="button" class="btn btn-sm btn-outline-danger remove-answer">
                <i class="fas fa-trash"></i> Remove
            </button>
        </div>
    </div>
');

$this->registerJs("
    $(function() {
        var answerIndex = " . count($answers) . ";
        var answersContainer = $('#answers-container');
        
        // Add new answer
        $('#add-answer').click(function() {
            var newAnswer = '" . $answerTemplate . "'.replace(/{index}/g, answerIndex);
            answersContainer.append(newAnswer);
            answerIndex++;
            updateRemoveButtons();
        });
        
        // Remove answer
        $(document).on('click', '.remove-answer', function() {
            if ($('.answer-item').length > 1) {
                $(this).closest('.answer-item').remove();
                updateRemoveButtons();
                reindexAnswers();
            }
        });
        
        // Update remove buttons visibility
        function updateRemoveButtons() {
            if ($('.answer-item').length <= 1) {
                $('.remove-answer').hide();
            } else {
                $('.remove-answer').show();
            }
        }
        
        // Reindex answers after removal
        function reindexAnswers() {
            $('.answer-item').each(function(index) {
                var item = $(this);
                item.attr('data-index', index);
                item.find('input, select').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        var newName = name.replace(/\\[\\d+\\]/, '[' + index + ']');
                        $(this).attr('name', newName);
                    }
                });
            });
        }
        
        // Form validation
        $('#questionnaire-form').on('submit', function(e) {
            var hasCorrectAnswer = false;
            $('input[name*=\"[is_correct]\"]:checked').each(function() {
                hasCorrectAnswer = true;
                return false;
            });
            
            if (!hasCorrectAnswer) {
                e.preventDefault();
                alert('At least one answer must be marked as correct.');
                return false;
            }
            
            var hasAnswers = false;
            $('input[name*=\"[answer_text]\"]').each(function() {
                if ($(this).val().trim()) {
                    hasAnswers = true;
                    return false;
                }
            });
            
            if (!hasAnswers) {
                e.preventDefault();
                alert('At least one answer must be provided.');
                return false;
            }
        });
        
        // Initialize
        updateRemoveButtons();
    });
");
?>
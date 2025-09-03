<?php

/** @var $this yii\web\View */
/** @var $questions common\models\QuestionnaireQuestion[] */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Server Rules Questionnaire';
$this->registerCssFile('@web/css/questionnaire.css');
$this->registerJsFile('@web/js/questionnaire.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="questionnaire-container">
	<div class="questionnaire-header">
		<h1>Server Rules Questionnaire</h1>
		<p>Please answer all questions correctly to continue</p>
	</div>

	<?php if (empty($questions)): ?>
		<div class="questionnaire-empty">
			<div class="empty-icon">📋</div>
			<h3>No Questions Available</h3>
			<p>No questionnaire has been configured yet. Please contact an administrator.</p>
		</div>
	<?php else: ?>
		<div class="questionnaire-progress">
			<div class="progress-bar">
				<div class="progress-fill" id="progressFill"></div>
			</div>
			<div class="progress-text">
				Question <span id="currentQuestion">1</span> of <?= count($questions) ?>
			</div>
		</div>

		<div class="questionnaire-content">
			<?php foreach ($questions as $index => $question): ?>
				<div class="question-step <?= $index === 0 ? 'active' : '' ?>" data-question="<?= $index ?>">
					<div class="question-card">
						<div class="question-header">
							<h2><?= Html::encode($question->question_text) ?></h2>
						</div>

						<div class="answers-container">
							<?php foreach ($question->answers as $answer): ?>
								<div class="answer-option">
									<input
										type="radio"
										name="answers[<?= (int)$question->id ?>]"
										id="q<?= (int)$question->id ?>_a<?= (int)$answer->id ?>"
										value="<?= (int)$answer->id ?>"
										class="answer-radio"
										data-question="<?= $index ?>"
										data-answer="<?= (int)$answer->id ?>">
									<label for="q<?= (int)$question->id ?>_a<?= (int)$answer->id ?>" class="answer-label">
										<span class="radio-circle"></span>
										<span class="answer-text"><?= Html::encode($answer->answer_text) ?></span>
									</label>
								</div>
							<?php endforeach; ?>
						</div>

						<div class="question-actions">
							<?php if ($index > 0): ?>
								<button type="button" class="btn btn-secondary btn-prev" data-question="<?= $index ?>">
									← Previous
								</button>
							<?php endif; ?>

							<?php if ($index < count($questions) - 1): ?>
								<button type="button" class="btn btn-primary btn-next" data-question="<?= $index ?>" disabled>
									Next →
								</button>
							<?php else: ?>
								<button type="button" class="btn btn-success btn-submit" data-question="<?= $index ?>" disabled>
									Submit Answers
								</button>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>



		<!-- Hidden form for submission -->
		<?php $form = ActiveForm::begin(['id' => 'questionnaireForm', 'options' => ['class' => 'hidden-form']]); ?>
		<div id="answersInputs"></div>
		<?= Html::submitButton('Submit', ['id' => 'submitBtn', 'class' => 'hidden-submit']) ?>
		<?php ActiveForm::end(); ?>
	<?php endif; ?>
</div>
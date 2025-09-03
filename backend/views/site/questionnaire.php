<?php
/** @var $this yii\web\View */
/** @var $questions common\models\QuestionnaireQuestion[] */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Server Rules Questionnaire';
?>

<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<div class="card shadow-sm">
				<div class="card-header bg-primary text-white">
					<h5 class="mb-0">Please answer all questions correctly to continue</h5>
				</div>
				<div class="card-body">
					<?php if (empty($questions)): ?>
						<div class="alert alert-info">No questionnaire has been configured yet. Please contact an administrator.</div>
					<?php else: ?>
						<?php $form = ActiveForm::begin(); ?>
						<?php foreach ($questions as $index => $question): ?>
							<div class="mb-4">
								<h6 class="fw-bold mb-3"><?= Html::encode(($index + 1) . '. ' . $question->question_text) ?></h6>
								<?php foreach ($question->answers as $answer): ?>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="answers[<?= (int)$question->id ?>]" id="q<?= (int)$question->id ?>_a<?= (int)$answer->id ?>" value="<?= (int)$answer->id ?>">
										<label class="form-check-label" for="q<?= (int)$question->id ?>_a<?= (int)$answer->id ?>">
											<?= Html::encode($answer->answer_text) ?>
										</label>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endforeach; ?>
						<div class="d-grid">
							<?= Html::submitButton('Submit Answers', ['class' => 'btn btn-success']) ?>
						</div>
						<?php ActiveForm::end(); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
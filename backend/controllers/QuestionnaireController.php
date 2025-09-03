<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\QuestionnaireQuestion;
use common\models\QuestionnaireAnswer;

/**
 * QuestionnaireController handles the management of questionnaire questions and answers.
 */
class QuestionnaireController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            switch ($action->id) {
                                case 'index':
                                case 'view':
                                    return Yii::$app->permissionChecker->can('view_questionnaire_questions');
                                case 'create':
                                    return Yii::$app->permissionChecker->can('create_questionnaire_questions');
                                case 'update':
                                    return Yii::$app->permissionChecker->can('edit_questionnaire_questions');
                                case 'delete':
                                    return Yii::$app->permissionChecker->can('delete_questionnaire_questions');
                                case 'delete-answer':
                                    return Yii::$app->permissionChecker->can('manage_questionnaire_answers');
                                case 'toggle-question':
                                    return Yii::$app->permissionChecker->can('toggle_questionnaire_questions');
                                case 'reorder':
                                    return Yii::$app->permissionChecker->can('reorder_questionnaire_questions');
                                default:
                                    return Yii::$app->permissionChecker->can('manage_questionnaire');
                            }
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'delete-answer' => ['POST'],
                    'toggle-question' => ['POST'],
                    'reorder' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all questionnaire questions.
     *
     * @return string
     */
    public function actionIndex()
    {
        $questions = QuestionnaireQuestion::find()
            ->with(['answers'])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        return $this->render('index', [
            'questions' => $questions,
        ]);
    }

    /**
     * Displays a single question.
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the question cannot be found
     */
    public function actionView($id)
    {
        $question = $this->findQuestion($id);

        return $this->render('view', [
            'question' => $question,
        ]);
    }

    /**
     * Creates a new question.
     *
     * @return string|Response
     */
    public function actionCreate()
    {
        $question = new QuestionnaireQuestion();
        $answers = [new QuestionnaireAnswer()];

        if ($question->load(Yii::$app->request->post()) && $question->save()) {
            $answers = $this->loadAnswers($question->id, Yii::$app->request->post('QuestionnaireAnswer', []));

            if ($this->saveAnswers($answers)) {
                Yii::$app->session->setFlash('success', 'Question created successfully.');
                return $this->redirect(['view', 'id' => $question->id]);
            }
        }

        return $this->render('create', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    /**
     * Updates an existing question.
     *
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException if the question cannot be found
     */
    public function actionUpdate($id)
    {
        $question = $this->findQuestion($id);
        $answers = $question->answers;

        if ($question->load(Yii::$app->request->post()) && $question->save()) {
            $answers = $this->loadAnswers($question->id, Yii::$app->request->post('QuestionnaireAnswer', []));

            if ($this->saveAnswers($answers)) {
                Yii::$app->session->setFlash('success', 'Question updated successfully.');
                return $this->redirect(['view', 'id' => $question->id]);
            }
        }

        return $this->render('update', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    /**
     * Deletes a question.
     *
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException if the question cannot be found
     */
    public function actionDelete($id)
    {
        $question = $this->findQuestion($id);

        if ($question->delete()) {
            Yii::$app->session->setFlash('success', 'Question deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete question.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes a specific answer.
     *
     * @param int $id
     * @return Response
     */
    public function actionDeleteAnswer($id)
    {
        $answer = QuestionnaireAnswer::findOne($id);

        if ($answer && $answer->delete()) {
            Yii::$app->session->setFlash('success', 'Answer deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete answer.');
        }

        return $this->redirect(['update', 'id' => $answer->question_id]);
    }

    /**
     * Toggles the active status of a question.
     *
     * @param int $id
     * @return Response
     */
    public function actionToggleQuestion($id)
    {
        $question = $this->findQuestion($id);
        $question->is_active = !$question->is_active;

        if ($question->save()) {
            $status = $question->is_active ? 'activated' : 'deactivated';
            Yii::$app->session->setFlash('success', "Question {$status} successfully.");
        } else {
            Yii::$app->session->setFlash('error', 'Failed to update question status.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Reorders questions.
     *
     * @return Response
     */
    public function actionReorder()
    {
        $order = Yii::$app->request->post('order', []);

        foreach ($order as $position => $questionId) {
            $question = QuestionnaireQuestion::findOne($questionId);
            if ($question) {
                $question->sort_order = $position;
                $question->save();
            }
        }

        Yii::$app->session->setFlash('success', 'Question order updated successfully.');
        return $this->redirect(['index']);
    }

    /**
     * Validates question and answers via AJAX.
     *
     * @return array
     */
    public function actionValidate()
    {
        $question = new QuestionnaireQuestion();
        $answers = [new QuestionnaireAnswer()];

        if ($question->load(Yii::$app->request->post())) {
            $answers = $this->loadAnswers(null, Yii::$app->request->post('QuestionnaireAnswer', []));

            $errors = [];
            if (!$question->validate()) {
                $errors['QuestionnaireQuestion'] = $question->errors;
            }

            foreach ($answers as $index => $answer) {
                if (!$answer->validate()) {
                    $errors["QuestionnaireAnswer[{$index}]"] = $answer->errors;
                }
            }

            if (!empty($errors)) {
                return ['success' => false, 'errors' => $errors];
            }
        }

        return ['success' => true];
    }

    /**
     * Finds the Question model based on its primary key value.
     *
     * @param int $id
     * @return QuestionnaireQuestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findQuestion($id)
    {
        if (($question = QuestionnaireQuestion::findOne($id)) !== null) {
            return $question;
        }

        throw new NotFoundHttpException('The requested question does not exist.');
    }

    /**
     * Loads answer models from POST data.
     *
     * @param int|null $questionId
     * @param array $answerData
     * @return QuestionnaireAnswer[]
     */
    protected function loadAnswers($questionId, $answerData)
    {
        $answers = [];

        foreach ($answerData as $index => $data) {
            if (isset($data['id']) && $data['id']) {
                $answer = QuestionnaireAnswer::findOne($data['id']);
            } else {
                $answer = new QuestionnaireAnswer();
            }

            $answer->load($data, '');
            if ($questionId) {
                $answer->question_id = $questionId;
            }
            $answer->sort_order = $index;

            $answers[] = $answer;
        }

        return $answers;
    }

    /**
     * Saves answer models.
     *
     * @param QuestionnaireAnswer[] $answers
     * @return bool
     */
    protected function saveAnswers($answers)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($answers as $answer) {
                if (!$answer->save()) {
                    $transaction->rollBack();
                    return false;
                }
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}

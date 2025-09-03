<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\User;
use common\models\Role;
use common\models\UserRole;
use yii\helpers\ArrayHelper;

/**
 * UserController handles user management and role assignments
 */
class UserController extends Controller
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
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->permissionChecker->can('view_users');
                        },
                    ],
                    [
                        'actions' => ['update', 'delete', 'ban', 'assign-role', 'remove-role'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->permissionChecker->can('edit_users');
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'ban' => ['post'],
                    'assign-role' => ['post'],
                    'remove-role' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all users
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $users = User::find()->with(['roles'])->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('index', [
            'users' => $users,
        ]);
    }

    /**
     * Displays a single user
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the user cannot be found
     */
    public function actionView($id)
    {
        $user = $this->findUser($id);

        return $this->render('view', [
            'user' => $user,
        ]);
    }

    /**
     * Updates an existing user
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the user cannot be found
     */
    public function actionUpdate($id)
    {
        $user = $this->findUser($id);
        $roles = Role::getRolesList();

        if (Yii::$app->request->isAjax && $user->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('success', 'User updated successfully.');
            return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('update', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Deletes an existing user
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the user cannot be found
     */
    public function actionDelete($id)
    {
        $user = $this->findUser($id);

        if ($user->id === Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'You cannot delete your own account.');
            return $this->redirect(['index']);
        }

        if ($user->delete()) {
            Yii::$app->session->setFlash('success', 'User deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete user.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Bans or unbans a user
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the user cannot be found
     */
    public function actionBan($id)
    {
        $user = $this->findUser($id);

        if ($user->id === Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'You cannot ban your own account.');
            return $this->redirect(['index']);
        }

        if ($user->status === User::STATUS_ACTIVE) {
            $user->status = User::STATUS_INACTIVE;
            $message = 'User banned successfully.';
        } else {
            $user->status = User::STATUS_ACTIVE;
            $message = 'User unbanned successfully.';
        }

        if ($user->save()) {
            Yii::$app->session->setFlash('success', $message);
        } else {
            Yii::$app->session->setFlash('error', 'Failed to update user status.');
        }

        return $this->redirect(['view', 'id' => $user->id]);
    }

    /**
     * Assigns a role to a user
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the user cannot be found
     */
    public function actionAssignRole($id)
    {
        $user = $this->findUser($id);
        $roleId = Yii::$app->request->post('role_id');

        if ($roleId && $user->assignRole($roleId)) {
            Yii::$app->session->setFlash('success', 'Role assigned successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to assign role.');
        }

        return $this->redirect(['view', 'id' => $user->id]);
    }

    /**
     * Removes a role from a user
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the user cannot be found
     */
    public function actionRemoveRole($id)
    {
        $user = $this->findUser($id);
        $roleId = Yii::$app->request->post('role_id');

        if ($roleId && $user->removeRole($roleId)) {
            Yii::$app->session->setFlash('success', 'Role removed successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to remove role.');
        }

        return $this->redirect(['view', 'id' => $user->id]);
    }

    /**
     * Finds the User model based on its primary key value
     *
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUser($id)
    {
        if (($user = User::findOne($id)) !== null) {
            return $user;
        }

        throw new NotFoundHttpException('The requested user does not exist.');
    }
}

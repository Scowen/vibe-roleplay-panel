<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

/**
 * Site controller for Vibe Roleplay Account Management
 */
class SiteController extends Controller
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'profile', 'change-password', 'update-profile', 'settings'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'update-profile' => ['post'],
                    'change-password' => ['get', 'post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays account dashboard.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $stats = [
            'totalPlaytime' => '24h 32m',
            'charactersCreated' => 3,
            'serverRank' => 'Member',
            'lastLogin' => date('M j, Y g:i A', strtotime($user->created_at)),
        ];

        return $this->render('index', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['index']);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['login']);
    }

    /**
     * Displays user profile.
     *
     * @return mixed
     */
    public function actionProfile()
    {
        $user = Yii::$app->user->identity;

        return $this->render('profile', [
            'user' => $user,
        ]);
    }

    /**
     * Allows users to change their password.
     *
     * @return mixed
     */
    public function actionChangePassword()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        if (Yii::$app->request->isPost) {
            $currentPassword = Yii::$app->request->post('current_password');
            $newPassword = Yii::$app->request->post('new_password');
            $confirmPassword = Yii::$app->request->post('confirm_password');

            if (!$user->validatePassword($currentPassword)) {
                Yii::$app->session->setFlash('error', 'Current password is incorrect.');
                return $this->redirect(['profile']);
            }

            if ($newPassword !== $confirmPassword) {
                Yii::$app->session->setFlash('error', 'New passwords do not match.');
                return $this->redirect(['profile']);
            }

            if (strlen($newPassword) < 6) {
                Yii::$app->session->setFlash('error', 'Password must be at least 6 characters long.');
                return $this->redirect(['profile']);
            }

            $user->setPassword($newPassword);
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Password updated successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update password.');
            }

            return $this->redirect(['profile']);
        }

        // Display the change password form
        return $this->render('change-password', [
            'user' => $user,
        ]);
    }

    /**
     * Displays user settings.
     *
     * @return mixed
     */
    public function actionSettings()
    {
        $user = Yii::$app->user->identity;

        return $this->render('settings', [
            'user' => $user,
        ]);
    }

    /**
     * Allows users to update their profile information.
     *
     * @return mixed
     */
    public function actionUpdateProfile()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        if (Yii::$app->request->isPost) {
            $user->username = Yii::$app->request->post('username');
            $user->email = Yii::$app->request->post('email');

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update profile.');
            }
        }

        return $this->redirect(['profile']);
    }
}

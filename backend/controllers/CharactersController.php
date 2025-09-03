<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\models\Character;

class CharactersController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    // future actions
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Character::find()->where(['user_id' => Yii::$app->user->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = Character::find()->where(['id' => $id, 'user_id' => Yii::$app->user->id])->one();
        if (!$model) {
            throw new NotFoundHttpException('Character not found.');
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
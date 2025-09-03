<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\Role;
use common\models\Permission;
use common\models\RolePermission;
use yii\helpers\ArrayHelper;

/**
 * RoleController handles role and permission management
 */
class RoleController extends Controller
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
                            return Yii::$app->permissionChecker->can('view_user_roles');
                        },
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->permissionChecker->can('manage_roles');
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all roles
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $roles = Role::find()->orderBy(['name' => SORT_ASC])->all();

        return $this->render('index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Displays a single role
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the role cannot be found
     */
    public function actionView($id)
    {
        $role = $this->findRole($id);

        return $this->render('view', [
            'role' => $role,
        ]);
    }

    /**
     * Creates a new role
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $role = new Role();
        $permissions = Permission::getGroupedPermissions();

        if (Yii::$app->request->isAjax && $role->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($role);
        }

        if ($role->load(Yii::$app->request->post()) && $role->save()) {
            // Assign permissions
            $permissionIds = Yii::$app->request->post('permissions', []);
            $role->assignPermissions($permissionIds);

            Yii::$app->session->setFlash('success', 'Role created successfully.');
            return $this->redirect(['view', 'id' => $role->id]);
        }

        return $this->render('create', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Updates an existing role
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the role cannot be found
     */
    public function actionUpdate($id)
    {
        $role = $this->findRole($id);
        $permissions = Permission::getGroupedPermissions();

        if (Yii::$app->request->isAjax && $role->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($role);
        }

        if ($role->load(Yii::$app->request->post()) && $role->save()) {
            // Update permissions
            $permissionIds = Yii::$app->request->post('permissions', []);
            $role->assignPermissions($permissionIds);

            Yii::$app->session->setFlash('success', 'Role updated successfully.');
            return $this->redirect(['view', 'id' => $role->id]);
        }

        return $this->render('update', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Deletes an existing role
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the role cannot be found
     */
    public function actionDelete($id)
    {
        $role = $this->findRole($id);

        if (!$role->canDelete()) {
            Yii::$app->session->setFlash('error', 'This role cannot be deleted.');
            return $this->redirect(['index']);
        }

        if ($role->delete()) {
            Yii::$app->session->setFlash('success', 'Role deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete role.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Role model based on its primary key value
     *
     * @param integer $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findRole($id)
    {
        if (($role = Role::findOne($id)) !== null) {
            return $role;
        }

        throw new NotFoundHttpException('The requested role does not exist.');
    }
}

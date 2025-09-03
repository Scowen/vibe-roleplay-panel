<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$this->title = 'Admin Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-dashboard">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <!-- Role Management -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-tag me-2"></i>
                        Role Management
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Manage user roles and permissions throughout the system.</p>

                    <div class="d-grid gap-2">
                        <?php if (Yii::$app->permissionChecker->can('view_user_roles')): ?>
                            <?= Html::a('View All Roles', ['/role/index'], ['class' => 'btn btn-primary']) ?>
                        <?php endif; ?>

                        <?php if (Yii::$app->permissionChecker->can('manage_roles')): ?>
                            <?= Html::a('Create New Role', ['/role/create'], ['class' => 'btn btn-success']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Management -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>
                        User Management
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Manage users, assign roles, and control access to the system.</p>

                    <div class="d-grid gap-2">
                        <?php if (Yii::$app->permissionChecker->can('view_users')): ?>
                            <?= Html::a('View All Users', ['/user/index'], ['class' => 'btn btn-primary']) ?>
                        <?php endif; ?>

                        <?php if (Yii::$app->permissionChecker->can('edit_users')): ?>
                            <?= Html::a('Manage Users', ['/user/index'], ['class' => 'btn btn-warning']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Statistics -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        System Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary"><?= \common\models\User::find()->count() ?></h4>
                            <small class="text-muted">Total Users</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success"><?= \common\models\Role::find()->count() ?></h4>
                            <small class="text-muted">Total Roles</small>
                        </div>
                    </div>
                    <div class="row text-center mt-3">
                        <div class="col-6">
                            <h4 class="text-info"><?= \common\models\Permission::find()->count() ?></h4>
                            <small class="text-muted">Total Permissions</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning"><?= \common\models\User::find()->where(['status' => \common\models\User::STATUS_ACTIVE])->count() ?></h4>
                            <small class="text-muted">Active Users</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <?php if (Yii::$app->permissionChecker->can('manage_questionnaire')): ?>
                            <?= Html::a('Manage Questionnaire', ['/site/questionnaire'], ['class' => 'btn btn-outline-primary']) ?>
                        <?php endif; ?>

                        <?php if (Yii::$app->permissionChecker->can('view_system_logs')): ?>
                            <?= Html::a('View System Logs', ['#'], ['class' => 'btn btn-outline-secondary']) ?>
                        <?php endif; ?>

                        <?php if (Yii::$app->permissionChecker->can('manage_system_settings')): ?>
                            <?= Html::a('System Settings', ['#'], ['class' => 'btn btn-outline-warning']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>
                        Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Details</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        <em>No recent activity to display</em>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
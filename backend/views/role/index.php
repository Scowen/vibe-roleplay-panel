<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $roles common\models\Role[] */

$this->title = 'Roles & Permissions';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="role-index">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php if (Yii::$app->permissionChecker->can('manage_roles')): ?>
            <?= Html::a('Create New Role', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <div class="row">
        <?php foreach ($roles as $role): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><?= Html::encode($role->name) ?></h5>
                        <?php if ($role->is_system): ?>
                            <span class="badge bg-primary">System</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?= Html::encode($role->description) ?></p>

                        <h6>Permissions:</h6>
                        <div class="mb-3">
                            <?php
                            $permissions = $role->permissions;
                            if (!empty($permissions)): ?>
                                <div class="row">
                                    <?php foreach ($permissions as $permission): ?>
                                        <div class="col-12">
                                            <small class="text-muted">
                                                <strong><?= Html::encode($permission->category) ?>:</strong>
                                                <?= Html::encode($permission->description) ?>
                                            </small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <small class="text-muted">No permissions assigned</small>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between">
                            <small class="text-muted">
                                Users: <?= count($role->users) ?>
                            </small>
                            <small class="text-muted">
                                Created: <?= Yii::$app->formatter->asDate($role->created_at) ?>
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100" role="group">
                            <?= Html::a('View', ['view', 'id' => $role->id], ['class' => 'btn btn-outline-primary btn-sm']) ?>

                            <?php if (Yii::$app->permissionChecker->can('manage_roles') && !$role->is_system): ?>
                                <?= Html::a('Edit', ['update', 'id' => $role->id], ['class' => 'btn btn-outline-warning btn-sm']) ?>

                                <?php if ($role->canDelete()): ?>
                                    <?= Html::a('Delete', ['delete', 'id' => $role->id], [
                                        'class' => 'btn btn-outline-danger btn-sm',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this role?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
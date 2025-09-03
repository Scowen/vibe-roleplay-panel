<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $users common\models\User[] */

$this->title = 'User Management';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="row">
        <?php foreach ($users as $user): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><?= Html::encode($user->username) ?></h5>
                        <div>
                            <?php if ($user->status === $user::STATUS_ACTIVE): ?>
                                <span class="badge bg-success">Active</span>
                            <?php elseif ($user->status === $user::STATUS_INACTIVE): ?>
                                <span class="badge bg-warning">Banned</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>

                            <?php if ($user->hasCompletedQuestionnaire()): ?>
                                <span class="badge bg-info">Questionnaire Complete</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>Email:</strong> <?= Html::encode($user->email) ?><br>
                            <strong>Status:</strong> <?= $user->status === $user::STATUS_ACTIVE ? 'Active' : ($user->status === $user::STATUS_INACTIVE ? 'Banned' : 'Inactive') ?><br>
                            <strong>Joined:</strong> <?= Yii::$app->formatter->asDate($user->created_at) ?>
                        </p>

                        <h6>Roles:</h6>
                        <div class="mb-3">
                            <?php
                            $roles = $user->roles;
                            if (!empty($roles)): ?>
                                <?php foreach ($roles as $role): ?>
                                    <span class="badge bg-primary me-1"><?= Html::encode($role->name) ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <small class="text-muted">No roles assigned</small>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between">
                            <small class="text-muted">
                                Last updated: <?= Yii::$app->formatter->asDate($user->updated_at) ?>
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100" role="group">
                            <?= Html::a('View', ['view', 'id' => $user->id], ['class' => 'btn btn-outline-primary btn-sm']) ?>

                            <?php if (Yii::$app->permissionChecker->can('edit_users')): ?>
                                <?= Html::a('Edit', ['update', 'id' => $user->id], ['class' => 'btn btn-outline-warning btn-sm']) ?>

                                <?php if ($user->id !== Yii::$app->user->id): ?>
                                    <?php if ($user->status === $user::STATUS_ACTIVE): ?>
                                        <?= Html::a('Ban', ['ban', 'id' => $user->id], [
                                            'class' => 'btn btn-outline-danger btn-sm',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to ban this user?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    <?php else: ?>
                                        <?= Html::a('Unban', ['ban', 'id' => $user->id], [
                                            'class' => 'btn btn-outline-success btn-sm',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to unban this user?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    <?php endif; ?>

                                    <?= Html::a('Delete', ['delete', 'id' => $user->id], [
                                        'class' => 'btn btn-outline-danger btn-sm',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this user?',
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
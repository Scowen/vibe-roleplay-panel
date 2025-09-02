<?php

/** @var $this yii\web\View */
/** @var $user common\models\User */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Profile';
?>

<div class="profile-container fade-in">
    <div class="profile-section">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h2><?= Html::encode($user->username) ?></h2>
                <div class="user-email"><?= Html::encode($user->email) ?></div>
                <div class="user-meta" style="margin-top: 0.5rem; color: #6c757d; font-size: 0.9rem;">
                    Member since <?= date('F j, Y', strtotime($user->created_at)) ?>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="profile-form">
            <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">Edit Profile Information</h3>

            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'profile-update-form'],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'text-danger', 'style' => 'font-size: 0.875rem; margin-top: 0.25rem;'],
                ],
            ]); ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $form->field($user, 'email')->textInput(['maxlength' => true, 'type' => 'email']) ?>
                    </div>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 2rem;">
                <?= Html::submitButton(
                    '<i class="fas fa-save"></i> Update Profile',
                    ['class' => 'btn btn-primary']
                ) ?>
                <a href="<?= Yii::$app->urlManager->createUrl(['/']) ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <!-- Account Security Section -->
    <div class="profile-section" style="margin-top: 2rem;">
        <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">Account Security</h3>

        <div class="security-options" style="display: grid; gap: 1rem;">
            <div class="security-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                            <i class="fas fa-key" style="color: #667eea; margin-right: 0.5rem;"></i>
                            Change Password
                        </h4>
                        <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                            Update your account password to keep it secure
                        </p>
                    </div>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/change-password']) ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Change
                    </a>
                </div>
            </div>

            <div class="security-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                            <i class="fas fa-shield-alt" style="color: #28a745; margin-right: 0.5rem;"></i>
                            Two-Factor Authentication
                        </h4>
                        <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                            Add an extra layer of security to your account
                        </p>
                    </div>
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-plus"></i> Enable
                    </button>
                </div>
            </div>

            <div class="security-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                            <i class="fas fa-history" style="color: #ffc107; margin-right: 0.5rem;"></i>
                            Login History
                        </h4>
                        <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                            View your recent login activity and sessions
                        </p>
                    </div>
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-eye"></i> View
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Statistics -->
    <div class="profile-section" style="margin-top: 2rem;">
        <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">Account Statistics</h3>

        <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 0.5rem; text-align: center; border: 1px solid #e9ecef;">
                <div class="stat-icon" style="width: 3rem; height: 3rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value" style="font-size: 1.5rem; font-weight: 700; color: #2c3e50; margin-bottom: 0.5rem;">
                    <?= date('M j', strtotime($user->created_at)) ?>
                </div>
                <div class="stat-label" style="color: #6c757d; font-size: 0.9rem;">Account Created</div>
            </div>

            <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 0.5rem; text-align: center; border: 1px solid #e9ecef;">
                <div class="stat-icon" style="width: 3rem; height: 3rem; background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value" style="font-size: 1.5rem; font-weight: 700; color: #2c3e50; margin-bottom: 0.5rem;">
                    <?= date('Y') - date('Y', strtotime($user->created_at)) ?>
                </div>
                <div class="stat-label" style="color: #6c757d; font-size: 0.9rem;">Years Active</div>
            </div>

            <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 0.5rem; text-align: center; border: 1px solid #e9ecef;">
                <div class="stat-icon" style="width: 3rem; height: 3rem; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white;">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-value" style="font-size: 1.5rem; font-weight: 700; color: #2c3e50; margin-bottom: 0.5rem;">
                    Member
                </div>
                <div class="stat-label" style="color: #6c757d; font-size: 0.9rem;">Account Status</div>
            </div>
        </div>
    </div>
</div>
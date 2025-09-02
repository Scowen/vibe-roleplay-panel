<?php

/** @var $this yii\web\View */
/** @var $model common\models\LoginForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
?>

<div class="login-wrapper fade-in">
    <div class="login-card">
        <!-- Login Header -->
        <div class="login-header" style="text-align: center; margin-bottom: 2rem;">
            <div class="brand-logo" style="width: 5rem; height: 5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);">
                <i class="fas fa-gamepad" style="font-size: 2rem;"></i>
            </div>
            <h1 style="color: white; margin-bottom: 0.5rem; font-size: 2rem; font-weight: 700;">Vibe Roleplay</h1>
            <p style="color: rgba(255, 255, 255, 0.8); font-size: 1.1rem; margin: 0;">Admin Panel Access</p>
        </div>

        <!-- Login Form -->
        <div class="login-form">
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'login-form-form'],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'text-danger', 'style' => 'font-size: 0.875rem; margin-top: 0.25rem;'],
                ],
            ]); ?>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="loginform-username" class="form-label">
                    <i class="fas fa-user" style="color: #667eea; margin-right: 0.5rem;"></i>
                    Username
                </label>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Enter your username']) ?>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label for="loginform-password" class="form-label">
                    <i class="fas fa-lock" style="color: #667eea; margin-right: 0.5rem;"></i>
                    Password
                </label>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter your password']) ?>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <div class="form-check">
                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => '<div class="form-check">{input} {label}</div>',
                        'class' => 'form-check-input',
                        'labelOptions' => ['class' => 'form-check-label'],
                    ]) ?>
                </div>
            </div>

            <div class="form-actions">
                <?= Html::submitButton(
                    '<i class="fas fa-sign-in-alt"></i> Sign In',
                    ['class' => 'btn btn-login', 'style' => 'width: 100%; padding: 1rem; font-size: 1.1rem; font-weight: 600;']
                ) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <!-- Login Footer -->
        <div class="login-footer" style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255, 255, 255, 0.1);">
            <p style="color: rgba(255, 255, 255, 0.7); font-size: 0.9rem; margin-bottom: 1rem;">
                Having trouble signing in?
            </p>
            <div class="help-links" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="#" class="help-link" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;">
                    <i class="fas fa-question-circle" style="margin-right: 0.25rem;"></i>
                    Help
                </a>
                <a href="#" class="help-link" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;">
                    <i class="fas fa-envelope" style="margin-right: 0.25rem;"></i>
                    Contact Support
                </a>
                <a href="#" class="help-link" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;">
                    <i class="fas fa-book" style="margin-right: 0.25rem;"></i>
                    Documentation
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .login-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1rem;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1rem;
        padding: 3rem;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        color: white;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.875rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.4);
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        color: white;
    }

    .form-check-label {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
    }

    .form-check-input {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .help-link:hover {
        color: white !important;
    }

    @media (max-width: 576px) {
        .login-card {
            padding: 2rem;
            margin: 1rem;
        }

        .brand-logo {
            width: 4rem;
            height: 4rem;
        }

        .brand-logo i {
            font-size: 1.5rem;
        }

        h1 {
            font-size: 1.5rem;
        }
    }
</style>
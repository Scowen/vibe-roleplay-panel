<?php

/** @var $this yii\web\View */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Change Password';
?>

<div class="change-password-container fade-in">
    <div class="profile-section">
        <!-- Header -->
        <div class="section-header" style="text-align: center; margin-bottom: 2rem;">
            <div class="header-icon" style="width: 4rem; height: 4rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white;">
                <i class="fas fa-key" style="font-size: 1.5rem;"></i>
            </div>
            <h2 style="color: #2c3e50; margin-bottom: 0.5rem;">Change Your Password</h2>
            <p style="color: #6c757d; font-size: 1.1rem;">Keep your account secure by updating your password regularly</p>
        </div>

        <!-- Password Change Form -->
        <div class="password-form" style="max-width: 500px; margin: 0 auto;">
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'password-change-form'],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'text-danger', 'style' => 'font-size: 0.875rem; margin-top: 0.25rem;'],
                ],
            ]); ?>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="current_password" class="form-label">
                    <i class="fas fa-lock" style="color: #667eea; margin-right: 0.5rem;"></i>
                    Current Password
                </label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
                <div class="form-text" style="color: #6c757d; font-size: 0.875rem; margin-top: 0.25rem;">
                    Enter your current password to verify your identity
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="new_password" class="form-label">
                    <i class="fas fa-key" style="color: #28a745; margin-right: 0.5rem;"></i>
                    New Password
                </label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
                <div class="form-text" style="color: #6c757d; font-size: 0.875rem; margin-top: 0.25rem;">
                    Password must be at least 6 characters long
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label for="confirm_password" class="form-label">
                    <i class="fas fa-check-circle" style="color: #ffc107; margin-right: 0.5rem;"></i>
                    Confirm New Password
                </label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                <div class="form-text" style="color: #6c757d; font-size: 0.875rem; margin-top: 0.25rem;">
                    Re-enter your new password to confirm
                </div>
            </div>

            <!-- Password Strength Indicator -->
            <div class="password-strength" style="margin-bottom: 2rem;">
                <label class="form-label">Password Strength</label>
                <div class="strength-bar" style="height: 0.5rem; background: #e9ecef; border-radius: 0.25rem; overflow: hidden;">
                    <div class="strength-fill" id="strengthFill" style="height: 100%; width: 0%; transition: all 0.3s ease; background: #dc3545;"></div>
                </div>
                <div class="strength-text" id="strengthText" style="color: #6c757d; font-size: 0.875rem; margin-top: 0.25rem;">
                    Enter a password to see strength
                </div>
            </div>

            <div class="form-actions" style="display: flex; gap: 1rem; justify-content: center;">
                <?= Html::submitButton(
                    '<i class="fas fa-save"></i> Update Password',
                    ['class' => 'btn btn-primary']
                ) ?>
                <a href="<?= Yii::$app->urlManager->createUrl(['/profile']) ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Profile
                </a>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <!-- Password Tips -->
        <div class="password-tips" style="margin-top: 3rem; padding: 1.5rem; background: #f8f9fa; border-radius: 0.75rem; border: 1px solid #e9ecef;">
            <h4 style="color: #2c3e50; margin-bottom: 1rem;">
                <i class="fas fa-lightbulb" style="color: #ffc107; margin-right: 0.5rem;"></i>
                Password Security Tips
            </h4>
            <ul style="color: #6c757d; margin: 0; padding-left: 1.5rem;">
                <li style="margin-bottom: 0.5rem;">Use at least 8 characters for better security</li>
                <li style="margin-bottom: 0.5rem;">Include a mix of uppercase and lowercase letters</li>
                <li style="margin-bottom: 0.5rem;">Add numbers and special characters</li>
                <li style="margin-bottom: 0.5rem;">Avoid using personal information like birthdays</li>
                <li style="margin-bottom: 0;">Don't reuse passwords from other accounts</li>
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');

        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = '';

            if (password.length >= 6) strength += 20;
            if (password.length >= 8) strength += 20;
            if (password.match(/[a-z]/)) strength += 20;
            if (password.match(/[A-Z]/)) strength += 20;
            if (password.match(/[0-9]/)) strength += 10;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 10;

            if (strength < 40) {
                feedback = 'Weak';
                strengthFill.style.background = '#dc3545';
            } else if (strength < 70) {
                feedback = 'Fair';
                strengthFill.style.background = '#ffc107';
            } else if (strength < 90) {
                feedback = 'Good';
                strengthFill.style.background = '#28a745';
            } else {
                feedback = 'Strong';
                strengthFill.style.background = '#20c997';
            }

            strengthFill.style.width = strength + '%';
            strengthText.textContent = feedback + ' password';
        }

        function checkPasswordMatch() {
            const newPassword = newPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (confirmPassword && newPassword !== confirmPassword) {
                confirmPasswordInput.style.borderColor = '#dc3545';
                confirmPasswordInput.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
            } else {
                confirmPasswordInput.style.borderColor = '#ced4da';
                confirmPasswordInput.style.boxShadow = 'none';
            }
        }

        newPasswordInput.addEventListener('input', function() {
            checkPasswordStrength(this.value);
            if (confirmPasswordInput.value) {
                checkPasswordMatch();
            }
        });

        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    });
</script>
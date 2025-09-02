<?php

/** @var $this yii\web\View */
/** @var $user common\models\User */
/** @var $stats array */

use yii\bootstrap5\Html;

$this->title = 'Dashboard';
?>

<div class="dashboard-container fade-in">
    <!-- Welcome Section -->
    <div class="welcome-section" style="margin-bottom: 2rem;">
        <h2 style="color: #2c3e50; margin-bottom: 0.5rem;">Welcome back, <?= Html::encode($user->username) ?>!</h2>
        <p style="color: #6c757d; font-size: 1.1rem;">Here's what's happening with your account today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="dashboard-grid">
        <div class="dashboard-card slide-in">
            <div class="card-header">
                <div class="card-title">Total Playtime</div>
                <div class="card-icon primary">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="card-value"><?= Html::encode($stats['totalPlaytime']) ?></div>
            <div class="card-description">Your accumulated playtime across all sessions</div>
        </div>

        <div class="dashboard-card slide-in">
            <div class="card-header">
                <div class="card-title">Characters Created</div>
                <div class="card-icon success">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="card-value"><?= Html::encode($stats['charactersCreated']) ?></div>
            <div class="card-description">Number of characters you've created</div>
        </div>

        <div class="dashboard-card slide-in">
            <div class="card-header">
                <div class="card-title">Server Rank</div>
                <div class="card-icon warning">
                    <i class="fas fa-crown"></i>
                </div>
            </div>
            <div class="card-value"><?= Html::encode($stats['serverRank']) ?></div>
            <div class="card-description">Your current rank on the server</div>
        </div>

        <div class="dashboard-card slide-in">
            <div class="card-header">
                <div class="card-title">Last Login</div>
                <div class="card-icon info">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="card-value"><?= Html::encode($stats['lastLogin']) ?></div>
            <div class="card-description">When you last accessed the server</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions" style="margin-top: 2rem;">
        <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">Quick Actions</h3>
        <div class="action-buttons" style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="<?= Yii::$app->urlManager->createUrl(['/profile']) ?>" class="btn btn-primary">
                <i class="fas fa-user-edit"></i>
                Edit Profile
            </a>
            <a href="<?= Yii::$app->urlManager->createUrl(['/change-password']) ?>" class="btn btn-secondary">
                <i class="fas fa-key"></i>
                Change Password
            </a>
            <a href="<?= Yii::$app->urlManager->createUrl(['/settings']) ?>" class="btn btn-secondary">
                <i class="fas fa-cog"></i>
                Account Settings
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="recent-activity" style="margin-top: 3rem;">
        <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">Recent Activity</h3>
        <div class="activity-list" style="background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
            <div class="activity-item" style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid #e9ecef;">
                <div class="activity-icon" style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <div class="activity-details">
                    <div class="activity-title" style="font-weight: 600; color: #2c3e50;">Logged in to the server</div>
                    <div class="activity-time" style="color: #6c757d; font-size: 0.9rem;"><?= date('M j, Y g:i A') ?></div>
                </div>
            </div>

            <div class="activity-item" style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid #e9ecef;">
                <div class="activity-icon" style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="activity-details">
                    <div class="activity-title" style="font-weight: 600; color: #2c3e50;">Created new character</div>
                    <div class="activity-time" style="color: #6c757d; font-size: 0.9rem;"><?= date('M j, Y', strtotime('-2 days')) ?></div>
                </div>
            </div>

            <div class="activity-item" style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0;">
                <div class="activity-icon" style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-star"></i>
                </div>
                <div class="activity-details">
                    <div class="activity-title" style="font-weight: 600; color: #2c3e50;">Achievement unlocked</div>
                    <div class="activity-time" style="color: #6c757d; font-size: 0.9rem;"><?= date('M j, Y', strtotime('-5 days')) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
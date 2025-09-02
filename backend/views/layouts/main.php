<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use backend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - Vibe Roleplay Admin</title>
    <?php $this->head() ?>

    <!-- Fallback Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Fallback CSS to ensure basic styling works -->
    <style>
        /* Critical CSS for basic layout */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .sidebar-brand i {
            font-size: 1.5rem;
            color: #ffd700;
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
        }

        .sidebar-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.875rem 1.5rem;
            display: block;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .sidebar-nav .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .btn-logout {
            width: 100%;
            background-color: rgba(220, 53, 69, 0.8);
            border: none;
            color: white;
            padding: 0.75rem;
            border-radius: 0.375rem;
            cursor: pointer;
        }

        .top-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 2rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.75rem;
            font-weight: 600;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .notifications {
            position: relative;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
        }

        .notifications:hover {
            background-color: #f8f9fa;
        }

        .notifications i {
            font-size: 1.25rem;
            color: #6c757d;
        }

        .notifications .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-menu {
            display: flex;
            align-items: center;
        }

        .avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            border: 2px solid #e9ecef;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .avatar:hover {
            transform: scale(1.05);
        }

        .page-content {
            padding: 2rem;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .card-icon.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-icon.success {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
        }

        .card-icon.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .card-icon.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .card-description {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }
        }
    </style>
</head>

<body class="admin-body">
    <?php $this->beginBody() ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <i class="fas fa-gamepad"></i>
                    <span>Vibe Roleplay</span>
                </div>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <?php
                $menuItems = [
                    [
                        'label' => '<i class="fas fa-tachometer-alt"></i> Dashboard',
                        'url' => ['/'],
                        'active' => Yii::$app->controller->action->id === 'index',
                    ],
                    [
                        'label' => '<i class="fas fa-user"></i> Profile',
                        'url' => ['/profile'],
                        'active' => Yii::$app->controller->action->id === 'profile',
                    ],
                    [
                        'label' => '<i class="fas fa-key"></i> Change Password',
                        'url' => ['/change-password'],
                        'active' => Yii::$app->controller->action->id === 'change-password',
                    ],
                    [
                        'label' => '<i class="fas fa-cog"></i> Settings',
                        'url' => ['/settings'],
                        'active' => Yii::$app->controller->action->id === 'settings',
                    ],
                ];

                echo Nav::widget([
                    'options' => ['class' => 'nav flex-column'],
                    'items' => $menuItems,
                    'encodeLabels' => false,
                ]);
                ?>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="user-details">
                        <div class="username"><?= Html::encode(Yii::$app->user->identity->username) ?></div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
                <?= Html::beginForm(['/logout'], 'post', ['class' => 'logout-form']) ?>
                <?= Html::submitButton(
                    '<i class="fas fa-sign-out-alt"></i> Logout',
                    ['class' => 'btn btn-logout']
                ) ?>
                <?= Html::endForm() ?>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="header-content">
                    <div class="page-title">
                        <h1><?= Html::encode($this->title) ?></h1>
                    </div>
                    <div class="header-actions">
                        <div class="notifications">
                            <i class="fas fa-bell"></i>
                            <span class="badge">3</span>
                        </div>
                        <div class="user-menu">
                            <div class="avatar">
                                <?= strtoupper(substr(Yii::$app->user->identity->username, 0, 2)) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="page-content">
                <div class="container-fluid">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </main>
        </div>
    <?php else: ?>
        <!-- Login Layout -->
        <div class="login-container">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    <?php endif; ?>

    <!-- Fallback JavaScript for basic functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Basic sidebar toggle functionality
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });

            // Notification click functionality - removed alert popup

            // User avatar click functionality
            const userAvatar = document.querySelector('.avatar');
            if (userAvatar) {
                userAvatar.addEventListener('click', function() {
                    alert('User menu: Profile settings and account options');
                });
            }
        });
    </script>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();

<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => $params['appName'],
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => $params['appShortName'] . '-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
                'profile' => 'site/profile',
                'change-password' => 'site/change-password',
                'settings' => 'site/settings',
                'logout' => 'site/logout',
                'questionnaire' => 'site/questionnaire',
                'admin-dashboard' => 'site/admin-dashboard',
                'roles' => 'role/index',
                'roles/create' => 'role/create',
                'roles/<id:\d+>' => 'role/view',
                'roles/<id:\d+>/update' => 'role/update',
                'roles/<id:\d+>/delete' => 'role/delete',
                'users' => 'user/index',
                'users/create' => 'user/create',
                'users/<id:\d+>' => 'user/view',
                'users/<id:\d+>/update' => 'user/update',
                'users/<id:\d+>/delete' => 'user/delete',
                'users/<id:\d+>/ban' => 'user/ban',
                'users/<id:\d+>/assign-role' => 'user/assign-role',
                'users/<id:\d+>/remove-role' => 'user/remove-role',
                'questionnaire-management' => 'questionnaire/index',
                'questionnaire-management/create' => 'questionnaire/create',
                'questionnaire-management/<id:\d+>' => 'questionnaire/view',
                'questionnaire-management/<id:\d+>/update' => 'questionnaire/update',
                'questionnaire-management/<id:\d+>/delete' => 'questionnaire/delete',
                'questionnaire-management/<id:\d+>/toggle' => 'questionnaire/toggle-question',
                'questionnaire-management/answer/<id:\d+>/delete' => 'questionnaire/delete-answer',
                'questionnaire-management/reorder' => 'questionnaire/reorder',
            ],
        ],
        'permissionChecker' => [
            'class' => 'common\components\PermissionChecker',
        ],
    ],
    'params' => $params,
];

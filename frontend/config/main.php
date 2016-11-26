<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            //'name' => 'advanced-frontend',
            //存文件
            //'savePath' => __DIR__ . '/../tmp',//手工在backend目录下新建文件夹TMP
            //存数据表
            'class' => 'yii\web\DbSession',
             'db' => 'db',  // 数据库连接的应用组件ID，默认为'db'.
             'sessionTable' => 'session', // session 数据表名，默认为'session'.
        ],
    ],
    'params' => $params,
];

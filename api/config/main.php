<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$urls = require __DIR__ . '/../../common/config/url/_urls-local.php';

return [
    'id' => 'app-api',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log', 'queue'],
    'modules' => [
        'v1' => [
            'class' => '\api\modules\v1\RestModule'
        ],
    ],
    'components' => [
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'baseUrl' => $urls['apiBaseUrl'],
        ],

        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response->format = \yii\web\Response::FORMAT_JSON;

                if (!$response->isSuccessful) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];

                }
            },
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:401',
                        'yii\web\HttpException:404',
                    ],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null,
        ],

        'urlManager' => require dirname(dirname(__DIR__)) . '/common/config/url/_api.php',
        /**/
    ],
    'params' => $params,
];

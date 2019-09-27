<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'path' => '@console/runtime/queue',
        ],
        'backUrlManager' => require __DIR__ . '/url/_backend.php',
        'apiUrlManager' => require __DIR__ . '/url/_api.php',
    ],
];

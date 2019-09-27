<?php

$urls = require __DIR__ .'/_urls-local.php';

return [
    'class' => '\yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        'POST v1/process-payment' => 'v1/payment/process-payment',
    ],
    'baseUrl' => $urls['apiBaseUrl'],
];
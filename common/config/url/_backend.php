<?php

$urls = require __DIR__ . '/_urls-local.php';

return [
    'class' => '\yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'baseUrl' => $urls['backendBaseUrl'],
    'rules' => [
    ],
];
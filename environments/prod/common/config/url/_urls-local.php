<?php

use yii\web\Request;

/** @var string $adminPostfix you can set 'admin', 'backend' This is related to your web server configuration */
$adminPostfix = 'backend';
/** @var string $apiPostfix you can set 'api', 'rest' This is related to your web server configuration */
$apiPostfix = 'api';

$backBaseUrl = str_replace('/backend/web', '/' . $adminPostfix, (new Request)->getBaseUrl());
$backBaseUrl = str_replace('/admin/web', '/' . $adminPostfix, $backBaseUrl);
$backBaseUrl = str_replace('/api/web', '/' . $adminPostfix, $backBaseUrl);
$backBaseUrl = str_replace('/rest/web', '/' . $adminPostfix, $backBaseUrl);

$apiBaseUrl = str_replace('/' . $adminPostfix, '/' . $apiPostfix, $backBaseUrl);


return [
    'apiBaseUrl' => $apiBaseUrl,
    'backendBaseUrl' => $backBaseUrl,
];


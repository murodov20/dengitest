<?php


namespace console\controllers;


use common\models\User;
use console\entities\ClientSettings;
use yii\console\Controller;

class PrepareController extends Controller
{

    /** @var string */
    public $defaultAction = 'install';

    /**
     * Installs and configures application
     * @throws \yii\base\Exception
     */
    public function actionInstall()
    {
        $username = 'admin';
        $email = 'admin@email.com';
        $password = \Yii::$app->security->generateRandomString(10);
        if (!User::findByUsername($username)) {
            $user = User::create($username, $email, $password);
            if ($user->save()) {
                echo 'Created new User:' . PHP_EOL;
                echo 'username:'. $username  . PHP_EOL;
                echo 'email:' . $email . PHP_EOL;
                echo 'password:' . $password . PHP_EOL;
                ClientSettings::setSetting(ClientSettings::SETTING_ENCODED_AUTH_STR, base64_encode("{$username}:{$password}"));
                echo 'Added client settings' . PHP_EOL;
            }
        }
    }

}
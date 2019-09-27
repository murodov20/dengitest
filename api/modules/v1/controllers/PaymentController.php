<?php


namespace api\modules\v1\controllers;


use api\modules\v1\requests\ApiQuery;
use api\modules\v1\requests\ProcessPaymentQuery;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

/**
 * Class PaymentController
 * @package api\modules\v1\controllers
 */
class PaymentController extends Controller
{


    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
            /** @var User $user */
                $user = User::find()->where(['username' => $username])->one();
                if ($user->verifyPassword($password)) {
                    return $user;
                }
                return null;
            },
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'process-payment' => ['post'],
            ],
        ];
        return $behaviors;
    }

    /**
     * Process payments
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionProcessPayment()
    {
        return $this->processRequest(new ProcessPaymentQuery());
    }

    /**
     * This function need for extending application. If you want add new functions to application add new action and new Query and it is all :)
     * @param ApiQuery $query
     * @return array
     * @throws BadRequestHttpException
     */
    protected function processRequest(ApiQuery $query)
    {
        if ($query->load(\Yii::$app->request->post(), '')) {
            if ($query->validate() && $query->processQuery()) {
                return $query->formulateResponse();
            }
            return [
                'success' => false,
                'errors' => $query->errors,
            ];
        }
        throw new BadRequestHttpException("Cannot load data");
    }
}
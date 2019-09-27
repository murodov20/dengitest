<?php


namespace console\controllers;


use console\jobs\PrepareTransactionJob;
use yii\console\Controller;
use yii\queue\Queue;

/**
 * Class ControlTransactions
 * @package console\controllers
 */
class ExecutePaymentsController extends Controller
{

    public $defaultAction = 'index';


    /**
     * This action will run every minutes and executes new PrepareTransactionJob with timeout - 20 seconds.
     */
    public function actionIndex()
    {
        /** @var Queue $queue */
        $queue = \Yii::$app->queue;
        /** run immediately */
        $queue->push(new PrepareTransactionJob(['start_time' => 0]));
        /** run after 20 seconds */
        $queue->delay(20)->push(new PrepareTransactionJob(['start_time' => 20]));
        /** run after 40 seconds */
        $queue->delay(40)->push(new PrepareTransactionJob(['start_time' => 40]));
    }

}
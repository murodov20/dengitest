<?php


namespace console\jobs;


use console\entities\ClientSettings;
use console\entities\ClientTransaction;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

class PrepareTransactionJob extends BaseObject implements JobInterface
{

    public $start_time = 0;

    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     * @throws \Exception
     */
    public function execute($queue)
    {
        /** @var Queue $newQueue */
        $newQueue = \Yii::$app->queue;
        $count = mt_rand(1, 10);
        $authString = ClientSettings::getSetting(ClientSettings::SETTING_ENCODED_AUTH_STR);
        for ($i = 0; $i < $count; $i++) {
            $generated = ClientTransaction::generate();



            if ($generated && $generated->save()) {

                // send to queue for sending by http (available for asynchronous sending when queue workers more than 1)
                $newQueue->delay(1)->push(new SendTransactionJob([
                    'id' => $generated->id,
                    'order_number' => $generated->order_number,
                    'sum' => $generated->sum,
                    'commission' => $generated->commission,
                    'auth' => $authString,
                ]));

            } else {
                throw new \Exception('Cannot create new client transactions');
            }
        }
    }
}
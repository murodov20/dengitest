<?php


namespace api\modules\v1\jobs;



use api\modules\v1\entities\UserWallet;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

class NewPaymentJob extends BaseObject implements JobInterface
{
    /** @var integer transaction id in client's server */
    public $id;

    /** @var double payment amount */
    public $sum;

    /** @var double commission of payment */
    public $commission;

    /** @var int client id */
    public $order_number;

    /** @var int */
    public $api_user_id;

    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     * @throws \Exception
     */
    public function execute($queue)
    {

        $sum  = $this->sum + $this->sum * $this->commission / 100.0;
        $tx = \api\modules\v1\entities\Transaction::add($this->id, $this->order_number, $sum, $this->api_user_id);
        if (!$tx) {
            \Yii::error("", 'api');
            throw new \Exception("Cannot add new transaction data, transaction id - {$this->id}");
        }
        $wallet = UserWallet::increaseBalance($this->order_number, $this->sum, $this->api_user_id);
        if (!$wallet) {
            throw new \Exception("Cannot increase balance, transaction id - {$this->id}");
        }
    }
}
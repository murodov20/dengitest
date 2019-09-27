<?php


namespace api\modules\v1\requests;


use api\modules\v1\entities\Transaction;
use api\modules\v1\jobs\NewPaymentJob;
use yii\helpers\ArrayHelper;
use yii\queue\Queue;

class ProcessPaymentQuery extends ApiQuery
{
    /** @var double transaction id */
    public $id;

    /** @var double payment amount. RUB */
    public $sum;

    /** @var double payment commission */
    public $commission;

    /** @var integer client id */
    public $order_number;

    /** @var array attributes for hashing, note:need order */
    public $hashProperties = ['id', 'sum', 'commission', 'order_number', 'salt'];

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['id', 'sum', 'commission', 'order_number'], 'required'],
            [['id'], 'integer'],
            ['id', 'checkIdForExist'],
            /** experimental: */
            ['sum', 'number', 'min' => 10, 'max' => 500],
            ['commission', 'number', 'min' => 0.5, 'max' => 2],
            ['order_number', 'integer', 'min' => 1, 'max' => 20],
        ]);
    }

    /**
     * Validator for transaction id, check for tx exists
     * @param $attribute
     * @param $params
     */
    public function checkIdForExist($attribute, $params)
    {
        if (Transaction::checkForExist($this->id)) {
            $this->addError($attribute, 'Transaction with this id already exists');
        }
    }

    /**
     * Process request and push data into queue for adding to transactions table
     * @param array|null $args
     * @return bool
     */
    public function processQuery(array $args = null): bool
    {
        /** @var Queue $queue */
        $queue = \Yii::$app->queue;


        /** add to queue */
        $queue->delay(1)->push(new NewPaymentJob([
            'id' => $this->id,
            'sum' => $this->sum,
            'commission' => $this->commission,
            'order_number' => $this->order_number,
            'api_user_id' => \Yii::$app->user->id,
        ]));
        return true;
    }

    /**
     * Formulate response
     * @param array|null $args
     * @return array
     */
    public function formulateResponse(array $args = null): array
    {
        return  [
            'success' => true,
            'message' => 'Pushed to queue',
            'errors' => null,
        ];
    }
}
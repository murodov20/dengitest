<?php


namespace console\jobs;


use console\helpers\GenerateHelper;
use yii\base\BaseObject;
use yii\httpclient\Client;
use yii\queue\JobInterface;
use yii\queue\Queue;
use yii\web\UrlManager;
use function GuzzleHttp\Psr7\str;

class SendTransactionJob extends BaseObject implements JobInterface
{

    /** @var integer */
    public $id;

    /** @var integer */
    public $order_number;

    /** @var double */
    public $sum;

    /** @var double */
    public $commission;

    /** @var string basic auth's encoded string */
    public $auth;

    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function execute($queue)
    {

        $salt = GenerateHelper::generateSalt();
        $hash = GenerateHelper::calculateHash([
            $this->id,
            $this->sum,
            $this->commission,
            $this->order_number,
            $salt,
        ], ';', 'md5');

        $client = new Client(['baseUrl' => \Yii::$app->params['api_base_url']]);
        $request = $client->createRequest();
        $request->headers->set('Authorization', 'Basic ' . $this->auth);
        $request->setMethod('POST')
            ->setUrl('v1/process-payment')
            ->setFormat(Client::FORMAT_JSON)
            ->setData([
                'id' => (int)$this->id,
                'order_number' => (int)$this->order_number,
                'sum' => (double)$this->sum,
                'commission' => (double)$this->commission,
                'salt' => (string)$salt,
                'hash' => (string)$hash,
            ]);

        $response = $request->send();

        if (!$response->getIsOk()) {
            \Yii::error('Cannot send transaction to API. Transaction id - ' . $this->id);
        }

    }
}
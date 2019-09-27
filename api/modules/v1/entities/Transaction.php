<?php


namespace api\modules\v1\entities;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * All transactions will be receive from api entry point will be save by this entity
 * Class Transactions
 * @package api\modules\v1\entities
 * @property int $id Id of tx in Payment server (current server)
 * @property int $external_id Id of tx from client database
 * @property int $api_user_id Api user id
 * @property int $user_id client id
 * @property double $sum amount including commission
 * @property int|string $created_at
 *
 */
class Transaction extends ActiveRecord
{

    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('UNIX_TIMESTAMP(NOW())'),
            ]
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%api_transactions}}';
    }

    /**
     * @param int $id Id of client's transaction
     * @param float $user_id client id
     * @param float $sum amount including commission
     * @param $api_user_id
     * @return static
     */
    public static function add(int $id, float $user_id, float $sum, $api_user_id): Transaction
    {
        $tx = new static([
            'external_id' => $id,
            'api_user_id' => $api_user_id,
            'user_id' => $user_id,
            'sum' => $sum,
        ]);
        return $tx->save() ? $tx : null;
    }

    public static function checkForExist($external_id)
    {
        $api_user_id = \Yii::$app->user->id;
        return Transaction::find()->where([
            'external_id' => $external_id,
            'api_user_id' => $api_user_id,
        ])->exists();
    }

}
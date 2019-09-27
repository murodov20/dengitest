<?php


namespace console\entities;


use console\helpers\GenerateHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property int $id
 * @property int $order_number
 * @property double $sum
 * @property double $commission
 * @property int $created_at
 *
 *
 * Class ClientTransaction
 * @package console\entities
 */
class ClientTransaction extends ActiveRecord
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
        return '{{%client_transactions}}';
    }

    /**
     * generates new transaction. not saves
     * @return ClientTransaction
     */
    public static function generate()
    {
        return new static([
            'order_number' => GenerateHelper::generateOrderNumber(),
            'sum' => GenerateHelper::generateSum(),
            'commission' => GenerateHelper::generateCommission(),
        ]);
    }
}
<?php


namespace api\modules\v1\entities;


use yii\db\ActiveRecord;

/**
 * Client's wallet
 *
 * Class UserWallet
 * @package api\modules\v1\entities
 * @property int $id
 * @property int $api_user_id Api user id
 * @property int $user_id Client id
 * @property int $sum Client's balance
 */
class UserWallet extends ActiveRecord
{


    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%api_user_wallets}}';
    }

    /**
     * increase balance for client
     * @param int $user_id client id
     * @param float $sum amount without
     * @param $api_user_id
     * @return UserWallet|array|ActiveRecord|null saved wallet
     */
    public static function increaseBalance(int $user_id, float $sum, $api_user_id) {
        $wallet = static::find()->where(['api_user_id' => $api_user_id, 'user_id' => $user_id])->one();
        if (!$wallet) {
            $wallet = new static(['api_user_id' => $api_user_id, 'user_id' => $user_id, 'sum' => 0]);
        }
        $wallet->sum = $wallet->sum + $sum;
        return $wallet->save() ? $wallet : null;
    }
}
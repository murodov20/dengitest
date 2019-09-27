<?php


namespace console\entities;


use yii\db\ActiveRecord;

/**
 * Class ClientSettings
 * @package console\entities
 *
 * @property string $key
 * @property string $value
 */
class ClientSettings extends ActiveRecord
{

    const SETTING_ENCODED_AUTH_STR = 'encoded_auth_str';


    public static function primaryKey()
    {
        return 'key';
    }

    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%client_settings}}';
    }

    /**
     * @param string $key key of setting
     * @param null $defaultValue
     * @return string
     */
    public static function getSetting($key, $defaultValue = null)
    {
        /** @var static $setting */
        $setting = static::find()->where(['key' => $key])->one();
        return $setting ? $setting->value : $defaultValue;
    }

    /**
     * @param $key string
     * @param $value string
     * @return bool
     */
    public static function setSetting($key, $value)
    {
        /** @var static $setting */
        $setting = static::find()->where(['key' => $key])->one();
        if (!$setting) {
            $setting = new static(['key' => $key]);
        }
        $setting->value = $value;
        return $setting->save();
    }
}
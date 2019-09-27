<?php

namespace api\modules\v1\validators;

use yii\validators\Validator;


class HashableValidator extends Validator
{

    /** @var array hashable fields, need order - [1,2,3, ... ] will be hashed as hash('1;2;3;...') */
    public $hashable = [];

    /** @var string separator for hashable fields */
    public $separator = ';';

    /** @var string hash function */
    public $hashFunction = 'md5';

    public $message;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        $this->message = 'Неправильный хеш данных';
    }

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $str = '';
        if (!empty($this->hashable)) {
            foreach ($this->hashable as $item) {
                if ($model->canGetProperty($item) && ($model->$item !== null)) {
                    $str = $str . (empty($str) ? '' : $this->separator) . $model->$item;
                }
            }
        }


        $hashedString = hash($this->hashFunction, $str);
        if ($hashedString !== $model->$attribute) {
            $model->addError($attribute, $this->message);
        }
    }

}
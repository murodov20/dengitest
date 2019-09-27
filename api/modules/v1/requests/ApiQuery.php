<?php


namespace api\modules\v1\requests;


use api\modules\v1\validators\HashableValidator;
use yii\base\Model;

abstract class ApiQuery extends Model
{

    /** @var string random data or timestamp */
    public $salt;

    /** @var string */
    public $hash;

    /** @var array all hashable properties for hashing, note - need order */
    public $hashProperties = ['salt'];

    /** @var array $hub Data store. For using to formulate responses */
    public $hub = [];

    public function rules()
    {
        return [
            [['hash', 'salt'], 'string'],
            [['hash', 'salt'], 'required'],
            [
                'hash',
                HashableValidator::class,
                'separator' => ';',                         /** ;,&,... */
                'hashFunction' => 'md5',                    /** md5, sha256, ... */
                'hashable' => $this->hashProperties,        /** ['salt', 'prop1', ...]  need order */
                'message' => 'Неправильный хеш данных',     /** message */
            ]
        ];
    }

    /**
     * Save to hub
     * @param string $key
     * @param $data
     */
    public function toHub(string $key, $data)
    {
        $this->hub[$key] = $data;
    }

    /**
     * Get from hub
     * @param string $key
     * @param array $defaultValue
     * @return array|mixed
     */
    public function fromHub(string $key, $defaultValue = [])
    {
        if (array_key_exists($key, $this->hub)) {
            return $this->hub[$key];
        }
        return $defaultValue;
    }

    /**
     * Process request
     * @param array|null $args
     * @return bool
     */
    public abstract function processQuery(array $args = null):bool;

    /**
     * Formulate response
     * @param array|null $args
     * @return array
     */
    public abstract function formulateResponse(array $args = null):array;
}
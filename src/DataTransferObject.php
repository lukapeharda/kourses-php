<?php

namespace KoursesPhp;

use Illuminate\Support\Str;

abstract class DataTransferObject
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Init new data object
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Fill up object data
     *
     * @param array $data
     */
    public function fill(array $data)
    {
        $this->data = $data;
    }

    /**
     * Return object as array
     *
     * @return array
     */
    public function toArray()
    {
        $data = [];

        // Process appends and add them to array as well
        $appends = [];

        if (count($this->appends) > 0) {
            foreach ($this->appends as $attribute) {
                $appends[$attribute] = $this->__get($attribute);
            }
        }

        return array_merge($data + $appends);
    }

    /**
     * Return object as array
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return @json_encode($this->toArray(), $options);
    }

    /**
     * Get object property
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        $attributeMethod = 'get' . Str::studly($key) . 'Attribute';

        if (method_exists($this, $attributeMethod)) {
            return $this->$attributeMethod();
        } elseif (isset($this->data[$key])) {
            return $this->data[$key];
        } elseif (isset($this->data[Str::snake($key)])) {
            return $this->data[Str::snake($key)];
        }
    }

    /**
     * Set object property
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public function __set($key, $value)
    {
        $attributeMethod = 'set' . Str::studly($key) . 'Attribute';

        if (method_exists($this, $attributeMethod)) {
            return $this->$attributeMethod($value);
        }

        return $this->data[$key] = $value;
    }

    /**
     * Override isset
     *
     * @param  string $key
     * @return bool
     */
    public function __isset($key)
    {
        $attribute = $this->$key;

        return ! empty($attribute);
    }
}

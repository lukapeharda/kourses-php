<?php

namespace KoursesPhp;

class ErrorBag
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * Init errors array.
     *
     * @param   array  $errors
     */
    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Return all errors.
     *
     * @return  array
     */
    public function all()
    {
        return $this->errors;
    }

    /**
     * Check if there is any error at all.
     *
     * @return  bool
     */
    public function any()
    {
        return is_array($this->errors) && count($this->errors) > 0;
    }

    /**
     * Check wheter there is any error for a given key.
     *
     * @param   string  $key
     *
     * @return  bool
     */
    public function has($key)
    {
        if (isset($this->errors[$key]) && is_array($this->errors[$key]) && count($this->errors[$key]) > 0) {
            return true;
        }

        return false;
    }

    /**
     * Get all errors for a given key.
     *
     * @param   string  $key
     *
     * @return  array
     */
    public function get($key)
    {
        if ( ! $this->has($key)) {
            return null;
        }

        return $this->errors[$key];
    }

    /**
     * Return first error message for a given key.
     *
     * @param   string  $key
     *
     * @return  string
     */
    public function first($key)
    {
        if ( ! $this->has($key)) {
            return null;
        }

        return $this->errors[$key][0];
    }
}

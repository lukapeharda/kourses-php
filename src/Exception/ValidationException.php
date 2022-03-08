<?php

namespace KoursesPhp\Exception;

use KoursesPhp\ErrorBag;

class ValidationException extends \Exception
{
    /**
     * @var \KoursesPhp\ErrorBag
     */
    protected $errorBag;

    /**
     * Set error bag in order for it to be read later on if needed.
     *
     * @param   \KoursesPhp\ErrorBag  $errorBag
     *
     * @return  self
     */
    public function setErrorBag(ErrorBag $errorBag)
    {
        $this->errorBag = $errorBag;

        return $this;
    }

    /**
     * Return error bag with validation errors.
     *
     * @return  \KoursesPhp\ErrorBag
     */
    public function getErrorBag()
    {
        return $this->errorBag;
    }
}

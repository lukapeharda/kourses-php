<?php

namespace Kourses\Exception;

use Kourses\ErrorBag;

class ValidationException extends \Exception
{
    /**
     * @var \Kourses\ErrorBag
     */
    protected $errorBag;

    /**
     * Set error bag in order for it to be read later on if needed.
     *
     * @param   \Kourses\ErrorBag  $errorBag
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
     * @return  \Kourses\ErrorBag
     */
    public function getErrorBag()
    {
        return $this->errorBag;
    }
}

<?php

namespace KoursesPhp;

use KoursesPhp\Service\ServiceFactory;

class Client
{
    /**
     * @var \KoursesPhp\Service\ServiceFactory
     */
    private $serviceFactory;

    /**
     * @var string
     */
    protected $apiBaseUrl = 'https://app.kourses.com/api/';

    /**
     * @var string
     */
    protected $apiKey = null;

    /**
     * Return one of the available service from the service factory container.
     *
     * @param   string  $name
     *
     * @return  \KoursesPhp\Service\AbstractService
     */
    public function __get($name)
    {
        if ($this->serviceFactory === null) {
            $this->serviceFactory = new ServiceFactory($this);
        }

        return $this->serviceFactory->__get($name);
    }

    /**
     * Return API key.
     *
     * @return  string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set API key.
     *
     * @param   string  $apiKey
     *
     * @return  self
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Return API base URL.
     *
     * @return  string
     */
    public function getApiBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    /**
     * Set API base URL.
     *
     * Allows to set different Kourses API URL. Can be used to access Kourses
     * beta installation.
     *
     * @param   string  $apiBaseUrl
     *
     * @return  self
     */
    public function setApiBaseUrl(string $apiBaseUrl): self
    {
        $this->apiBaseUrl = $apiBaseUrl;

        return $this;
    }

    /**
     * Make a HTTP request to the Kourses platform.
     *
     * @param   string  $method
     * @param   string  $path
     * @param   array  $params
     *
     * @return  array
     */
    public function request($method, $path, $params)
    {
        $requestor = new ApiRequestor($this->getApiKey(), $this->getApiBaseUrl());

        return $requestor->request($method, $path, $params);
    }
}

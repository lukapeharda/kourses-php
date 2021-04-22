<?php

namespace Kourses\Service;

use Kourses\Client;

abstract class AbstractService
{
    /**
     * @var \Kourses\Client
     */
    protected $client;

    /**
     * Init client.
     *
     * @param   \Kourses\Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns client.
     *
     * @return  \Kourses\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Runs a request on the underlying client.
     *
     * @param   string  $method
     * @param   string  $path
     * @param   array  $params
     *
     * @return  mixed
     */
    protected function request($method, $path, $params)
    {
        return $this->getClient()->request($method, $path, $params);
    }
}

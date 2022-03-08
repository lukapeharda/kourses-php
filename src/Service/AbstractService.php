<?php

namespace KoursesPhp\Service;

use KoursesPhp\Client;

abstract class AbstractService
{
    /**
     * @var \KoursesPhp\Client
     */
    protected $client;

    /**
     * Init client.
     *
     * @param   \KoursesPhp\Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns client.
     *
     * @return  \KoursesPhp\Client
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

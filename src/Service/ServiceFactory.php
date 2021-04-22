<?php

namespace Kourses\Service;

use Kourses\Client;

class ServiceFactory
{
    /**
     * @var array
     */
    private static $classMap = [
        'members' => \Kourses\Service\MembersService::class,
        'products' => \Kourses\Service\ProductsService::class,
        'permissions' => \Kourses\Service\PermissionsService::class,
        'memberProducts' => \Kourses\Service\MemberProductsService::class,
    ];

    /**
     * @var \Kourses\Client
     */
    private $client;

    /**
     * @var array
     */
    private $services;

    /**
     * Init client.
     *
     * @param   \Kourses\Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->services = [];
    }

    /**
     * Accessor for API service.
     *
     * Does a lazy instantiation for a service and saves initialize service to
     * an array.
     *
     * @param   string  $name
     *
     * @return  \Kourses\Service\AbstractService
     */
    public function __get($name)
    {
        $serviceClass = $this->getServiceClass($name);

        if (null !== $serviceClass) {
            if ( ! \array_key_exists($name, $this->services)) {
                $this->services[$name] = new $serviceClass($this->client);
            }

            return $this->services[$name];
        }

        \trigger_error('Undefined property: ' . static::class . '::$' . $name);

        return null;
    }

    /**
     * Returns service class from a given name.
     *
     * @param   string  $name
     *
     * @return  string
     */
    protected function getServiceClass($name)
    {
        return \array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}

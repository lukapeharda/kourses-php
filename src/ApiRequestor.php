<?php

namespace Kourses;

use GuzzleHttp\Client;

use Kourses\Exception\ValidationException;
use Kourses\Exception\InvalidJsonException;
use Kourses\Exception\UnauthorizedException;
use Kourses\Exception\InvalidRequestException;
use Kourses\Exception\MethodNotSupportedException;

class ApiRequestor
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Init HTTP client and set defaults.
     *
     * @param   string  $apiKey
     * @param   string  $apiBaseUrl
     */
    public function __construct($apiKey, $apiBaseUrl)
    {
        $this->client = new Client([
            'base_uri' => $apiBaseUrl,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ],
            'http_errors' => false,
            'verify' => false,
        ]);
    }

    /**
     * Run a GET HTTP request.
     *
     * @param   string  $path
     * @param   array  $query
     *
     * @return  \Psr\Http\Message\ResponseInterface
     */
    protected function get($path, $query)
    {
        return $this->client->get($path, [
            'query' => $query,
        ]);
    }

    /**
     * Run a POST HTTP request.
     *
     * Params will be set as form parameters.
     *
     * @param   string  $path
     * @param   array  $query
     *
     * @return  \Psr\Http\Message\ResponseInterface
     */
    protected function post($path, $params)
    {
        return $this->client->post($path, [
            'form_params' => $params,
        ]);
    }

    /**
     * Run a DELETE HTTP request.
     *
     * Params will be set as query string parameters.
     *
     * @param   string  $path
     * @param   array  $query
     *
     * @return  \Psr\Http\Message\ResponseInterface
     */
    protected function delete($path, $query)
    {
        return $this->client->delete($path, [
            'query' => $query,
        ]);
    }

    /**
     * Run an HTTP request and handle errors. Returns decoded JSON.
     *
     * @param   string  $method
     * @param   string  $path
     * @param   array  $params
     *
     * @throws \Kourses\Exception\MethodNotSupportedException when HTTP method requested is not implemented
     * @throws \Kourses\Exception\UnauthorizedException when API token is invalid or missing
     * @throws \Kourses\Exception\InvalidRequestException when API URL is invalid
     * @throws \Kourses\Exception\ValidationException when param validation errors are thrown by the Kourses platform
     * @throws \Kourses\Exception\InvalidJsonException when invalid JSON was returned
     * @throws \Kourses\Exception\InvalidRequestException when any other non successful HTTP response is returned
     *
     * @return  array
     */
    public function request($method, $path, $params)
    {
        switch (strtolower($method)) {
            case 'get':
                $response = $this->get($path, $params);
                break;
            case 'post':
                $response = $this->post($path, $params);
                break;
            case 'delete':
                $response = $this->delete($path, $params);
                break;
            default:
                throw new MethodNotSupportedException("HTTP $method not supported");
        }

        if ($response->getStatusCode() === 401) {
            throw new UnauthorizedException("Unauthorized. API key either invalid or missing. Did you call 'Kourses\Client::setApiKey' method with an API key obtained in Kourses app?");
        }

        if ($response->getStatusCode() === 404) {
            throw new InvalidRequestException("API URL invalid. Can you check whether API base URL is correct?");
        }

        if ($response->getStatusCode() === 422) {
            $content = $this->decodeResponse($response);

            $validationException = new ValidationException($content['message']);
            $validationException->setErrorBag(new ErrorBag($content['errors']));

            throw $validationException;
        }

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            $content = $this->decodeResponse($response);

            if (isset($content['error']) && ! empty($content['error'])) {
                throw new InvalidRequestException($content['error']);
            }

            throw new InvalidRequestException($response->getReasonPhrase());
        }

        return $this->decodeResponse($response);
    }

    /**
     * Decode response body from JSON to array.
     *
     * @param   \Psr\Http\Message\ResponseInterface
     *
     * @throws  \Kourses\Exception\InvalidJsonException
     *
     * @return  array
     */
    protected function decodeResponse($response)
    {
        $decodedResponse = json_decode((string) $response->getBody(), true);

        if (json_last_error() !== \JSON_ERROR_NONE) {
            throw new InvalidJsonException(json_last_error_msg());
        }

        return $decodedResponse;
    }
}

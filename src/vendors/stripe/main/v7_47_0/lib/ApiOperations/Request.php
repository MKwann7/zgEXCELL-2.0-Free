<?php

namespace Stripe\ApiOperations;

use Stripe\Exception\ApiErrorException;
use Stripe\Util\RequestOptions;

/**
 * Trait for resources that need to make API requests.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait Request
{
    /**
     * @param mixed|null $params The list of parameters to validate
     *
     * @throws \Stripe\Exception\InvalidArgumentException if $params exists and is not an array
     */
    protected static function _validateParams(mixed $params = null): void
    {
        if ($params && !\is_array($params)) {
            $message = 'You must pass an array as the first argument to Stripe API '
               . 'method calls.  (HINT: an example call to create a charge '
               . "would be: \"Stripe\\Charge::create(['amount' => 100, "
               . "'currency' => 'usd', 'source' => 'tok_1234'])\")";

            throw new \Stripe\Exception\InvalidArgumentException($message);
        }
    }

    /**
     * @param string $method HTTP method ('get', 'post', etc.)
     * @param string $url URL for the request
     * @param array|null $params list of parameters for the request
     * @param array|string|null $options
     *
     * @return array tuple containing (the JSON response, $options)
     * @throws ApiErrorException if the request fails
     */
    protected function _request(string $method, string $url, array|null $params = [], array|string $options = null): array
    {
        $opts = $this->_opts->merge($options);
        list($resp, $options) = static::_staticRequest($method, $url, $params, $opts);
        $this->setLastResponse($resp);

        return [$resp->json, $options];
    }

    /**
     * @param string $method HTTP method ('get', 'post', etc.)
     * @param string $url URL for the request
     * @param array $params list of parameters for the request
     * @param array|string|null $options
     *
     * @return array tuple containing (the JSON response, $options)
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    protected static function _staticRequest(string $method, string $url, array $params, RequestOptions|array|string|null $options): array
    {
        $opts = \Stripe\Util\RequestOptions::parse($options);
        $baseUrl = $opts->apiBase ?? static::baseUrl();
        $requestor = new \Stripe\ApiRequestor($opts->apiKey, $baseUrl);
        list($response, $opts->apiKey) = $requestor->request($method, $url, $params, $opts->headers);
        $opts->discardNonPersistentHeaders();

        return [$response, $opts];
    }
}

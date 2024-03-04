<?php

namespace Stripe\ApiOperations;

/**
 * Trait for resources that have nested resources.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait NestedResource
{
    /**
     * @param string $method
     * @param string $url
     * @param array|null $params
     * @param array|string|null $options
     *
     * @return \Stripe\StripeObject
     */
    protected static function _nestedResourceOperation(string $method, string $url, array $params = null, array|string $options = null): \Stripe\StripeObject
    {
        self::_validateParams($params);

        list($response, $opts) = static::_staticRequest($method, $url, $params, $options);
        $obj = \Stripe\Util\Util::convertToStripeObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param string|null $nestedId
     *
     * @return string
     */
    protected static function _nestedResourceUrl(string $id, string $nestedPath, string $nestedId = null): string
    {
        $url = static::resourceUrl($id) . $nestedPath;
        if (null !== $nestedId) {
            $url .= "/{$nestedId}";
        }

        return $url;
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param array|null $params
     * @param array|string|null $options
     *
     * @return \Stripe\StripeObject
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    protected static function _createNestedResource(string $id, string $nestedPath, array $params = null, array|string $options = null): \Stripe\StripeObject
    {
        $url = static::_nestedResourceUrl($id, $nestedPath);

        return self::_nestedResourceOperation('post', $url, $params, $options);
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param string|null $nestedId
     * @param array|null $params
     * @param array|string|null $options
     *
     * @return \Stripe\StripeObject
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    protected static function _retrieveNestedResource(string $id, string $nestedPath, ?string $nestedId, array $params = null, array|string $options = null): \Stripe\StripeObject
    {
        $url = static::_nestedResourceUrl($id, $nestedPath, $nestedId);

        return self::_nestedResourceOperation('get', $url, $params, $options);
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param string|null $nestedId
     * @param array|null $params
     * @param array|string|null $options
     *
     * @return \Stripe\StripeObject
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    protected static function _updateNestedResource(string $id, string $nestedPath, ?string $nestedId, array $params = null, array|string $options = null): \Stripe\StripeObject
    {
        $url = static::_nestedResourceUrl($id, $nestedPath, $nestedId);

        return self::_nestedResourceOperation('post', $url, $params, $options);
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param string|null $nestedId
     * @param array|null $params
     * @param array|string|null $options
     *
     * @return \Stripe\StripeObject
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    protected static function _deleteNestedResource(string $id, string $nestedPath, ?string $nestedId, array $params = null, array|string $options = null): \Stripe\StripeObject
    {
        $url = static::_nestedResourceUrl($id, $nestedPath, $nestedId);

        return self::_nestedResourceOperation('delete', $url, $params, $options);
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param array|null $params
     * @param array|string|null $options
     *
     * @return \Stripe\StripeObject
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    protected static function _allNestedResources(string $id, string $nestedPath, array $params = null, array|string $options = null): \Stripe\StripeObject
    {
        $url = static::_nestedResourceUrl($id, $nestedPath);

        return self::_nestedResourceOperation('get', $url, $params, $options);
    }
}

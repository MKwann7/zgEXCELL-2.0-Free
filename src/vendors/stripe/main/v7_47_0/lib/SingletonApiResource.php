<?php

namespace Stripe;

use Stripe\Exception\ApiErrorException;
use Stripe\Util\RequestOptions;

/**
 * Class SingletonApiResource.
 */
abstract class SingletonApiResource extends ApiResource
{
    /**
     * @param array|string|null $options
     * @return SingletonApiResource
     * @throws ApiErrorException
     */
    protected static function _singletonRetrieve(array|string $options = null): static
    {
        $opts = Util\RequestOptions::parse($options);
        $instance = new static(null, $opts);
        $instance->refresh();

        return $instance;
    }

    /**
     * @return string the endpoint associated with this singleton class
     */
    public static function classUrl(): string
    {
        // Replace dots with slashes for namespaced resources, e.g. if the object's name is
        // "foo.bar", then its URL will be "/v1/foo/bar".
        $base = \str_replace('.', '/', static::OBJECT_NAME);

        return "/v1/{$base}";
    }

    /**
     * @return string the endpoint associated with this singleton API resource
     */
    public function instanceUrl(): string
    {
        return static::classUrl();
    }
}

<?php

namespace Stripe;

use Stripe\Util\Set;

/**
 * Class ApiResource.
 */
abstract class ApiResource extends StripeObject
{
    use ApiOperations\Request;

    /**
     * @var bool A flag that can be set a behavior that will cause this
     * resource to be encoded and sent up along with an update of its parent
     * resource. This is usually not desirable because resources are updated
     * individually on their own endpoints, but there are certain cases,
     * replacing a customer's source for example, where this is allowed.
     */
    public bool $saveWithParent = false;

    /**
     * @return Set|null A list of fields that can be their own type of
     * API resource (say a nested card under an account for example), and if
     * that resource is set, it should be transmitted to the API on a create or
     * update. Doing so is not the default behavior because API resources
     * should normally be persisted on their own RESTful endpoints.
     */
    public static function getSavedNestedResources(): ?Util\Set
    {
        static $savedNestedResources = null;
        if (null === $savedNestedResources) {
            $savedNestedResources = new Util\Set();
        }

        return $savedNestedResources;
    }

    /**
     * @param $k
     * @param $v
     * @return void
     */
    public function __set($k, $v): void
    {
        parent::__set($k, $v);
        $v = $this->{$k};
        if ((static::getSavedNestedResources()->includes($k)) &&
            ($v instanceof ApiResource)) {
            $v->saveWithParent = true;
        }
    }

    /**
     * @throws Exception\ApiErrorException
     *
     * @return ApiResource the refreshed resource
     */
    public function refresh(): static
    {
        $requestor = new ApiRequestor($this->_opts->apiKey, static::baseUrl());
        $url = $this->instanceUrl();

        list($response, $this->_opts->apiKey) = $requestor->request(
            'get',
            $url,
            $this->_retrieveOptions,
            $this->_opts->headers
        );
        $this->setLastResponse($response);
        $this->refreshFrom($response->json, $this->_opts);

        return $this;
    }

    /**
     * @return string the base URL for the given class
     */
    public static function baseUrl(): string
    {
        return Stripe::$apiBase;
    }

    /**
     * @return string the endpoint URL for the given class
     */
    public static function classUrl(): string
    {
        // Replace dots with slashes for namespaced resources, e.g. if the object's name is
        // "foo.bar", then its URL will be "/v1/foo/bars".
        $base = \str_replace('.', '/', static::OBJECT_NAME);

        return "/v1/{$base}s";
    }

    /**
     * @param string|null $id the ID of the resource
     *
     * @return string the instance endpoint URL for the given class
     *@throws Exception\UnexpectedValueException if $id is null
     *
     */
    public static function resourceUrl(?string $id): string
    {
        if (null === $id) {
            $class = static::class;
            $message = 'Could not determine which URL to request: '
               . "{$class} instance has invalid ID: {$id}";

            throw new Exception\UnexpectedValueException($message);
        }
        $id = Util\Util::utf8($id);
        $base = static::classUrl();
        $extn = \urlencode($id);

        return "{$base}/{$extn}";
    }

    /**
     * @return string the full API URL for this API resource
     */
    public function instanceUrl(): string
    {
        return static::resourceUrl($this['id']);
    }
}

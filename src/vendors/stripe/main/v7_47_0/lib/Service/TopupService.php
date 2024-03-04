<?php

// File generated from our OpenAPI spec

namespace Stripe\Service;

use Stripe\StripeObject;
use Stripe\Topup;
use Stripe\Util\RequestOptions;

class TopupService extends AbstractService
{
    /**
     * Returns a list of top-ups.
     *
     * @param array|null $params
     * @param RequestOptions|array|null $opts
     *
     * @return \Stripe\Collection
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function all(array $params = null, RequestOptions|array $opts = null): \Stripe\Collection
    {
        return $this->requestCollection('get', '/v1/topups', $params, $opts);
    }

    /**
     * Cancels a top-up. Only pending top-ups can be canceled.
     *
     * @param string $id
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|Topup
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function cancel(string $id, array $params = null, RequestOptions|array $opts = null): StripeObject|Topup
    {
        return $this->request('post', $this->buildPath('/v1/topups/%s/cancel', $id), $params, $opts);
    }

    /**
     * Top up the balance of an account.AbstractServiceAlias
     *
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|Topup
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function create(array $params = null, RequestOptions|array $opts = null): StripeObject|Topup
    {
        return $this->request('post', '/v1/topups', $params, $opts);
    }

    /**
     * Retrieves the details of a top-up that has previously been created. Supply the
     * unique top-up ID that was returned from your previous request, and Stripe will
     * return the corresponding top-up information.
     *
     * @param string $id
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|Topup
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function retrieve(string $id, array $params = null, RequestOptions|array $opts = null): StripeObject|Topup
    {
        return $this->request('get', $this->buildPath('/v1/topups/%s', $id), $params, $opts);
    }

    /**
     * Updates the metadata of a top-up. Other top-up details are not editable by
     * design.
     *
     * @param string $id
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|Topup
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function update(string $id, array $params = null, RequestOptions|array $opts = null): StripeObject|Topup
    {
        return $this->request('post', $this->buildPath('/v1/topups/%s', $id), $params, $opts);
    }
}

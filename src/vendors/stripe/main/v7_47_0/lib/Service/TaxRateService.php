<?php

// File generated from our OpenAPI spec

namespace Stripe\Service;

use Stripe\Collection;
use Stripe\StripeObject;
use Stripe\TaxRate;
use Stripe\Util\RequestOptions;

class TaxRateService extends AbstractService
{
    /**
     * Returns a list of your tax rates. Tax rates are returned sorted by creation
     * date, with the most recently created tax rates appearing first.
     *
     * @param array|null $params
     * @param RequestOptions|array|null $opts
     *
     * @return Collection
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function all(array $params = null, RequestOptions|array $opts = null): Collection
    {
        return $this->requestCollection('get', '/v1/tax_rates', $params, $opts);
    }

    /**
     * Creates a new tax rate.
     *
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|TaxRate
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function create(array $params = null, RequestOptions|array $opts = null): StripeObject|TaxRate
    {
        return $this->request('post', '/v1/tax_rates', $params, $opts);
    }

    /**
     * Retrieves a tax rate with the given ID.
     *
     * @param string $id
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|TaxRate
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function retrieve(string $id, array $params = null, RequestOptions|array $opts = null): StripeObject|TaxRate
    {
        return $this->request('get', $this->buildPath('/v1/tax_rates/%s', $id), $params, $opts);
    }

    /**
     * Updates an existing tax rate.
     *
     * @param string $id
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|TaxRate
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function update(string $id, array $params = null, RequestOptions|array $opts = null): StripeObject|TaxRate
    {
        return $this->request('post', $this->buildPath('/v1/tax_rates/%s', $id), $params, $opts);
    }
}

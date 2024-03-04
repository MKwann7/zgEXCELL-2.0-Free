<?php

// File generated from our OpenAPI spec

namespace Stripe\Service;

use Stripe\Collection;
use Stripe\StripeObject;
use Stripe\Util\RequestOptions;
use Stripe\WebhookEndpoint;

class WebhookEndpointService extends AbstractService
{
    /**
     * Returns a list of your webhook endpoints.
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
        return $this->requestCollection('get', '/v1/webhook_endpoints', $params, $opts);
    }

    /**
     * A webhook endpoint must have a <code>url</code> and a list of
     * <code>enabled_events</code>. You may optionally specify the Boolean
     * <code>connect</code> parameter. If set to true, then a Connect webhook endpoint
     * that notifies the specified <code>url</code> about events from all connected
     * accounts is created; otherwise an account webhook endpoint that notifies the
     * specified <code>url</code> only about events from your account is created. You
     * can also create webhook endpoints in the <a
     * href="https://dashboard.stripe.com/account/webhooks">webhooks settings</a>
     * section of the Dashboard.
     *
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|WebhookEndpoint
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function create(array $params = null, RequestOptions|array $opts = null): WebhookEndpoint|StripeObject
    {
        return $this->request('post', '/v1/webhook_endpoints', $params, $opts);
    }

    /**
     * You can also delete webhook endpoints via the <a
     * href="https://dashboard.stripe.com/account/webhooks">webhook endpoint
     * management</a> page of the Stripe dashboard.
     *
     * @param string $id
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|WebhookEndpoint
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function delete(string $id, array $params = null, RequestOptions|array $opts = null): WebhookEndpoint|StripeObject
    {
        return $this->request('delete', $this->buildPath('/v1/webhook_endpoints/%s', $id), $params, $opts);
    }

    /**
     * Retrieves the webhook endpoint with the given ID.
     *
     * @param string $id
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|WebhookEndpoint
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function retrieve(string $id, array $params = null, RequestOptions|array $opts = null): WebhookEndpoint|StripeObject
    {
        return $this->request('get', $this->buildPath('/v1/webhook_endpoints/%s', $id), $params, $opts);
    }

    /**
     * Updates the webhook endpoint. You may edit the <code>url</code>, the list of
     * <code>enabled_events</code>, and the status of your endpoint.
     *
     * @param string $id
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|WebhookEndpoint
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function update(string $id, array $params = null, RequestOptions|array $opts = null): WebhookEndpoint|StripeObject
    {
        return $this->request('post', $this->buildPath('/v1/webhook_endpoints/%s', $id), $params, $opts);
    }
}

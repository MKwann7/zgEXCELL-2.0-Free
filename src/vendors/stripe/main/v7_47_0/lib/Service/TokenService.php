<?php

// File generated from our OpenAPI spec

namespace Stripe\Service;

use Stripe\StripeObject;
use Stripe\Token;
use Stripe\Util\RequestOptions;

class TokenService extends AbstractService
{
    /**
     * Creates a single-use token that represents a bank account’s details. This token
     * can be used with any API method in place of a bank account dictionary. This
     * token can be used only once, by attaching it to a <a href="#accounts">Custom
     * account</a>.
     *
     * @param array|null $params
     * @param RequestOptions|array|null $opts
     *
     * @return StripeObject|Token
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function create(array $params = null, RequestOptions|array $opts = null): StripeObject|Token
    {
        return $this->request('post', '/v1/tokens', $params, $opts);
    }

    /**
     * Retrieves the token with the given ID.
     *
     * @param string $id
     * @param array|null $params
     * @param array|RequestOptions|null $opts
     *
     * @return StripeObject|Token
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function retrieve(string $id, array $params = null, RequestOptions|array $opts = null): StripeObject|Token
    {
        return $this->request('get', $this->buildPath('/v1/tokens/%s', $id), $params, $opts);
    }
}

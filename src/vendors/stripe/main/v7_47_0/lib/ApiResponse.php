<?php

namespace Stripe;

use Stripe\Util\CaseInsensitiveArray;

/**
 * Class ApiResponse.
 */
class ApiResponse
{
    public array|null|CaseInsensitiveArray $headers;

    public string $body;

    public ?array $json;

    public int $code;

    /**
     * @param string $body
     * @param int $code
     * @param array|CaseInsensitiveArray|null $headers
     * @param array|null $json
     */
    public function __construct(string $body, int $code, CaseInsensitiveArray|array|null $headers, ?array $json)
    {
        $this->body = $body;
        $this->code = $code;
        $this->headers = $headers;
        $this->json = $json;
    }
}

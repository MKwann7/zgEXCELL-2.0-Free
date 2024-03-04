<?php

namespace Stripe;

use Stripe\Exception\ApiErrorException;
use Stripe\Exception\OAuth\OAuthErrorException;
use Stripe\Util\CaseInsensitiveArray;

/**
 * Class ApiRequestor.
 */
class ApiRequestor
{
    private ?string $_apiKey;

    private ?string $_apiBase;

    private static HttpClient\ClientInterface $_httpClient;

    private static RequestTelemetry|null $requestTelemetry;

    /**
     * ApiRequestor constructor.
     *
     * @param string|null $apiKey
     * @param string|null $apiBase
     */
    public function __construct(string $apiKey = null, string $apiBase = null)
    {
        $this->_apiKey = $apiKey;
        if (!$apiBase) {
            $apiBase = Stripe::$apiBase;
        }
        $this->_apiBase = $apiBase;
    }

    /**
     * Creates a telemetry json blob for use in 'X-Stripe-Client-Telemetry' headers.
     *
     * @static
     *
     * @param RequestTelemetry $requestTelemetry
     *
     * @return string
     */
    private static function _telemetryJson(RequestTelemetry $requestTelemetry): string
    {
        $payload = [
            'last_request_metrics' => [
                'request_id' => $requestTelemetry->requestId,
                'request_duration_ms' => $requestTelemetry->requestDuration,
            ],
        ];

        $result = \json_encode($payload);
        if (false !== $result) {
            return $result;
        }
        Stripe::getLogger()->error('Serializing telemetry payload failed!');

        return '{}';
    }

    /**
     * @static
     *
     * @param ApiResource|array|bool|mixed $d
     *
     * @return ApiResource|array|mixed|string
     */
    private static function _encodeObjects(mixed $d): mixed
    {
        if ($d instanceof ApiResource) {
            return Util\Util::utf8($d->id);
        }
        if (true === $d) {
            return 'true';
        }
        if (false === $d) {
            return 'false';
        }
        if (\is_array($d)) {
            $res = [];
            foreach ($d as $k => $v) {
                $res[$k] = self::_encodeObjects($v);
            }

            return $res;
        }

        return Util\Util::utf8($d);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array|null $params
     * @param null|array $headers
     *
     * @return array tuple containing (ApiReponse, API key)
     *@throws Exception\ApiErrorException
     *
     */
    public function request(string $method, string $url, array $params = null, $headers = null): array
    {
        $params = $params ?: [];
        $headers = $headers ?: [];
        list($rbody, $rcode, $rheaders, $myApiKey) =
        $this->_requestRaw($method, $url, $params, $headers);
        $json = $this->_interpretResponse($rbody, $rcode, $rheaders);
        $resp = new ApiResponse($rbody, $rcode, $rheaders, $json);

        return [$resp, $myApiKey];
    }

    /**
     * @param string $rbody a JSON string
     * @param int $rcode
     * @param array|CaseInsensitiveArray $rheaders
     * @param array $resp
     *
     * @throws ApiErrorException
     * @throws OAuthErrorException
     */
    public function handleErrorResponse(string $rbody, int $rcode, array|CaseInsensitiveArray $rheaders, array $resp): void
    {
        if (!\is_array($resp) || !isset($resp['error'])) {
            $msg = "Invalid response object from API: {$rbody} "
              . "(HTTP response code was {$rcode})";

            throw new Exception\UnexpectedValueException($msg);
        }

        $errorData = $resp['error'];

        $error = null;
        if (\is_string($errorData)) {
            $error = self::_specificOAuthError($rbody, $rcode, $rheaders, $resp, $errorData);
        }
        if (!$error) {
            $error = self::_specificAPIError($rbody, $rcode, $rheaders, $resp, $errorData);
        }

        throw $error;
    }

    /**
     * @static
     *
     * @param string $rbody
     * @param int $rcode
     * @param array|CaseInsensitiveArray $rheaders
     * @param array $resp
     * @param array $errorData
     *
     * @return ApiErrorException
     */
    private static function _specificAPIError(string $rbody, int $rcode, array|CaseInsensitiveArray $rheaders, array $resp, array $errorData): Exception\ApiErrorException
    {
        $msg = $errorData['message'] ?? null;
        $param = $errorData['param'] ?? null;
        $code = $errorData['code'] ?? null;
        $type = $errorData['type'] ?? null;
        $declineCode = $errorData['decline_code'] ?? null;

        switch ($rcode) {
            case 400:
                // 'rate_limit' code is deprecated, but left here for backwards compatibility
                // for API versions earlier than 2015-09-08
                if ('rate_limit' === $code) {
                    return Exception\RateLimitException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
                }
                if ('idempotency_error' === $type) {
                    return Exception\IdempotencyException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
                }

                // no break
            case 404:
                return Exception\InvalidRequestException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
            case 401:
                return Exception\AuthenticationException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
            case 402:
                return Exception\CardException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $declineCode, $param);
            case 403:
                return Exception\PermissionException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
            case 429:
                return Exception\RateLimitException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
            default:
                return Exception\UnknownApiErrorException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
        }
    }

    /**
     * @static
     *
     * @param bool|string $rbody
     * @param int $rcode
     * @param array|CaseInsensitiveArray $rheaders
     * @param array $resp
     * @param string $errorCode
     *
     * @return OAuthErrorException
     */
    private static function _specificOAuthError(bool|string $rbody, int $rcode, array|CaseInsensitiveArray $rheaders, array $resp, string $errorCode): Exception\OAuth\OAuthErrorException
    {
        $description = $resp['error_description'] ?? $errorCode;

        return match ($errorCode) {
            'invalid_client' => Exception\OAuth\InvalidClientException::factory($description, $rcode, $rbody, $resp, $rheaders, $errorCode),
            'invalid_grant' => Exception\OAuth\InvalidGrantException::factory($description, $rcode, $rbody, $resp, $rheaders, $errorCode),
            'invalid_request' => Exception\OAuth\InvalidRequestException::factory($description, $rcode, $rbody, $resp, $rheaders, $errorCode),
            'invalid_scope' => Exception\OAuth\InvalidScopeException::factory($description, $rcode, $rbody, $resp, $rheaders, $errorCode),
            'unsupported_grant_type' => Exception\OAuth\UnsupportedGrantTypeException::factory($description, $rcode, $rbody, $resp, $rheaders, $errorCode),
            'unsupported_response_type' => Exception\OAuth\UnsupportedResponseTypeException::factory($description, $rcode, $rbody, $resp, $rheaders, $errorCode),
            default => Exception\OAuth\UnknownOAuthErrorException::factory($description, $rcode, $rbody, $resp, $rheaders, $errorCode),
        };
    }

    /**
     * @static
     *
     * @param array|null $appInfo
     *
     * @return null|string
     */
    private static function _formatAppInfo(array|null $appInfo): ?string
    {
        if (null !== $appInfo) {
            $string = $appInfo['name'];
            if (null !== $appInfo['version']) {
                $string .= '/' . $appInfo['version'];
            }
            if (null !== $appInfo['url']) {
                $string .= ' (' . $appInfo['url'] . ')';
            }

            return $string;
        }

        return null;
    }

    /**
     * @static
     *
     * @param string $apiKey
     * @param null   $clientInfo
     *
     * @return array
     */
    private static function _defaultHeaders(string $apiKey, $clientInfo = null): array
    {
        $uaString = 'Stripe/v1 PhpBindings/' . Stripe::VERSION;

        $langVersion = \PHP_VERSION;
        $uname_disabled = \in_array('php_uname', \explode(',', \ini_get('disable_functions')), true);
        $uname = $uname_disabled ? '(disabled)' : \php_uname();

        $appInfo = Stripe::getAppInfo();
        $ua = [
            'bindings_version' => Stripe::VERSION,
            'lang' => 'php',
            'lang_version' => $langVersion,
            'publisher' => 'stripe',
            'uname' => $uname,
        ];
        if ($clientInfo) {
            $ua = \array_merge($clientInfo, $ua);
        }
        if (null !== $appInfo) {
            $uaString .= ' ' . self::_formatAppInfo($appInfo);
            $ua['application'] = $appInfo;
        }

        return [
            'X-Stripe-Client-User-Agent' => \json_encode($ua),
            'User-Agent' => $uaString,
            'Authorization' => 'Bearer ' . $apiKey,
        ];
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $headers
     *
     * @return array
     * @throws Exception\ApiConnectionException
     * @throws Exception\AuthenticationException
     */
    private function _requestRaw(string $method, string $url, array $params, array $headers): array
    {
        $myApiKey = $this->_apiKey;
        if (!$myApiKey) {
            $myApiKey = Stripe::$apiKey;
        }

        if (!$myApiKey) {
            $msg = 'No API key provided.  (HINT: set your API key using '
              . '"Stripe::setApiKey(<API-KEY>)".  You can generate API keys from '
              . 'the Stripe web interface.  See https://stripe.com/api for '
              . 'details, or email support@stripe.com if you have any questions.';

            throw new Exception\AuthenticationException($msg);
        }

        // Clients can supply arbitrary additional keys to be included in the
        // X-Stripe-Client-User-Agent header via the optional getUserAgentInfo()
        // method
        $clientUAInfo = null;
        if (\method_exists($this->httpClient(), 'getUserAgentInfo')) {
            $clientUAInfo = $this->httpClient()->getUserAgentInfo();
        }

        $absUrl = $this->_apiBase . $url;
        $params = self::_encodeObjects($params);
        $defaultHeaders = $this->_defaultHeaders($myApiKey, $clientUAInfo);
        if (Stripe::$apiVersion) {
            $defaultHeaders['Stripe-Version'] = Stripe::$apiVersion;
        }

        if (Stripe::$accountId) {
            $defaultHeaders['Stripe-Account'] = Stripe::$accountId;
        }

        if (Stripe::$enableTelemetry && isset(self::$requestTelemetry)) {
            $defaultHeaders['X-Stripe-Client-Telemetry'] = self::_telemetryJson(self::$requestTelemetry);
        }

        $hasFile = false;
        foreach ($params as $k => $v) {
            if (\is_resource($v)) {
                $hasFile = true;
                $params[$k] = self::_processResourceParam($v);
            } elseif ($v instanceof \CURLFile) {
                $hasFile = true;
            }
        }

        if ($hasFile) {
            $defaultHeaders['Content-Type'] = 'multipart/form-data';
        } else {
            $defaultHeaders['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        $combinedHeaders = \array_merge($defaultHeaders, $headers);
        $rawHeaders = [];

        foreach ($combinedHeaders as $header => $value) {
            $rawHeaders[] = $header . ': ' . $value;
        }

        $requestStartMs = Util\Util::currentTimeMillis();

        list($rbody, $rcode, $rheaders) = $this->httpClient()->request(
            $method,
            $absUrl,
            $rawHeaders,
            $params,
            $hasFile
        );

        if (isset($rheaders['request-id'], $rheaders['request-id'][0])) {
            self::$requestTelemetry = new RequestTelemetry(
                $rheaders['request-id'][0],
                Util\Util::currentTimeMillis() - $requestStartMs
            );
        }

        return [$rbody, $rcode, $rheaders, $myApiKey];
    }

    /**
     * @param resource $resource
     *
     * @throws Exception\InvalidArgumentException
     *
     * @return \CURLFile|string
     */
    private function _processResourceParam($resource): \CURLFile|string
    {
        if ('stream' !== \get_resource_type($resource)) {
            throw new Exception\InvalidArgumentException(
                'Attempted to upload a resource that is not a stream'
            );
        }

        $metaData = \stream_get_meta_data($resource);
        if ('plainfile' !== $metaData['wrapper_type']) {
            throw new Exception\InvalidArgumentException(
                'Only plainfile resource streams are supported'
            );
        }

        // We don't have the filename or mimetype, but the API doesn't care
        return new \CURLFile($metaData['uri']);
    }

    /**
     * @param string $rbody
     * @param int $rcode
     * @param array|CaseInsensitiveArray $rheaders
     *
     * @return array
     * @throws ApiErrorException
     */
    private function _interpretResponse(string $rbody, int $rcode, array|CaseInsensitiveArray $rheaders): array
    {
        $resp = \json_decode($rbody, true);
        $jsonError = \json_last_error();
        if (null === $resp && \JSON_ERROR_NONE !== $jsonError) {
            $msg = "Invalid response body from API: {$rbody} "
              . "(HTTP response code was {$rcode}, json_last_error() was {$jsonError})";

            throw new Exception\UnexpectedValueException($msg, $rcode);
        }

        if ($rcode < 200 || $rcode >= 300) {
            $this->handleErrorResponse($rbody, $rcode, $rheaders, $resp);
        }

        return $resp;
    }

    /**
     * @static
     *
     * @param HttpClient\ClientInterface $client
     */
    public static function setHttpClient(HttpClient\ClientInterface $client): void
    {
        self::$_httpClient = $client;
    }

    /**
     * @static
     *
     * Resets any stateful telemetry data
     */
    public static function resetTelemetry(): void
    {
        self::$requestTelemetry = null;
    }

    /**
     * @return HttpClient\ClientInterface
     */
    private function httpClient(): HttpClient\ClientInterface
    {
        if (!isset(self::$_httpClient)) {
            self::$_httpClient = HttpClient\CurlClient::instance();
        }

        return self::$_httpClient;
    }
}

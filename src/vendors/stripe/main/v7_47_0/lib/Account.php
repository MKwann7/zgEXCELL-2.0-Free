<?php

// File generated from our OpenAPI spec

namespace Stripe;

use Stripe\Exception\ApiErrorException;
use Stripe\Util\Set;

/**
 * This is an object representing a Stripe account. You can retrieve it to see
 * properties on the account like its current e-mail address or if the account is
 * enabled yet to make live charges.
 *
 * Some properties, marked below, are available only to platforms that want to <a
 * href="https://stripe.com/docs/connect/accounts">create and manage Express or
 * Custom accounts</a>.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property null|\Stripe\StripeObject $business_profile Business information about the account.
 * @property null|string $business_type The business type.
 * @property \Stripe\StripeObject $capabilities
 * @property bool $charges_enabled Whether the account can create live charges.
 * @property \Stripe\StripeObject $company
 * @property string $country The account's country.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property string $default_currency Three-letter ISO currency code representing the default currency for the account. This must be a currency that <a href="https://stripe.com/docs/payouts">Stripe supports in the account's country</a>.
 * @property bool $details_submitted Whether account details have been submitted. Standard accounts cannot receive payouts before this is true.
 * @property null|string $email The primary user's email address.
 * @property \Stripe\Collection $external_accounts External accounts (bank accounts and debit cards) currently attached to this account
 * @property \Stripe\Person $individual <p>This is an object representing a person associated with a Stripe account.</p><p>Related guide: <a href="https://stripe.com/docs/connect/identity-verification-api#person-information">Handling Identity Verification with the API</a>.</p>
 * @property \Stripe\StripeObject $metadata Set of <a href="https://stripe.com/docs/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property bool $payouts_enabled Whether Stripe can send payouts to this account.
 * @property \Stripe\StripeObject $requirements
 * @property null|\Stripe\StripeObject $settings Options for customizing how the account functions within Stripe.
 * @property \Stripe\StripeObject $tos_acceptance
 * @property string $type The Stripe account type. Can be <code>standard</code>, <code>express</code>, or <code>custom</code>.
 */
class Account extends ApiResource
{
    const OBJECT_NAME = 'account';

    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\NestedResource;
    use ApiOperations\Update;

    const BUSINESS_TYPE_COMPANY = 'company';
    const BUSINESS_TYPE_GOVERNMENT_ENTITY = 'government_entity';
    const BUSINESS_TYPE_INDIVIDUAL = 'individual';
    const BUSINESS_TYPE_NON_PROFIT = 'non_profit';

    const CAPABILITY_CARD_PAYMENTS = 'card_payments';
    const CAPABILITY_LEGACY_PAYMENTS = 'legacy_payments';
    const CAPABILITY_PLATFORM_PAYMENTS = 'platform_payments';
    const CAPABILITY_TRANSFERS = 'transfers';

    const CAPABILITY_STATUS_ACTIVE = 'active';
    const CAPABILITY_STATUS_INACTIVE = 'inactive';
    const CAPABILITY_STATUS_PENDING = 'pending';

    const TYPE_CUSTOM = 'custom';
    const TYPE_EXPRESS = 'express';
    const TYPE_STANDARD = 'standard';

    use ApiOperations\Retrieve {
        retrieve as protected _retrieve;
    }

    /**
     * @return Set|null
     */
    public static function getSavedNestedResources(): Util\Set|null
    {
        static $savedNestedResources = null;
        if (null === $savedNestedResources) {
            $savedNestedResources = new Util\Set([
                'external_account',
                'bank_account',
            ]);
        }

        return $savedNestedResources;
    }

    /**
     * @return string
     */
    public function instanceUrl(): string
    {
        if (null === $this['id']) {
            return '/v1/account';
        }

        return parent::instanceUrl();
    }

    /**
     * @param bool $force
     * @return array
     */
    public function serializeParameters(bool $force = false): array
    {
        $update = parent::serializeParameters($force);
        if (isset($this->_values['legal_entity'])) {
            $entity = $this['legal_entity'];
            if (isset($entity->_values['additional_owners'])) {
                $owners = $entity['additional_owners'];
                $entityUpdate = isset($update['legal_entity']) ? $update['legal_entity'] : [];
                $entityUpdate['additional_owners'] = $this->serializeAdditionalOwners($entity, $owners);
                $update['legal_entity'] = $entityUpdate;
            }
        }
        if (isset($this->_values['individual'])) {
            $individual = $this['individual'];
            if (($individual instanceof Person) && !isset($update['individual'])) {
                $update['individual'] = $individual->serializeParameters($force);
            }
        }

        return $update;
    }

    /**
     * @param $legalEntity
     * @param $additionalOwners
     * @return array
     */
    private function serializeAdditionalOwners($legalEntity, $additionalOwners): array
    {
        if (isset($legalEntity->_originalValues['additional_owners'])) {
            $originalValue = $legalEntity->_originalValues['additional_owners'];
        } else {
            $originalValue = [];
        }
        if (($originalValue) && (\count($originalValue) > \count($additionalOwners))) {
            throw new Exception\InvalidArgumentException(
                'You cannot delete an item from an array, you must instead set a new array'
            );
        }

        $updateArr = [];
        foreach ($additionalOwners as $i => $v) {
            $update = ($v instanceof StripeObject) ? $v->serializeParameters() : $v;

            if ($update !== []) {
                if (!$originalValue ||
                    !\array_key_exists($i, $originalValue) ||
                    ($update !== $legalEntity->serializeParamsValue($originalValue[$i], null, false, true))) {
                    $updateArr[$i] = $update;
                }
            }
        }

        return $updateArr;
    }

    /**
     * @param null|array|string $id the ID of the account to retrieve, or an
     *     options array containing an `id` key
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Account
     */
    public static function retrieve($id = null, $opts = null): Account
    {
        if (!$opts && \is_string($id) && str_starts_with($id, 'sk_')) {
            $opts = $id;
            $id = null;
        }

        return self::_retrieve($id, $opts);
    }

    /**
     * @param array|null $clientId
     * @param array|string|null $opts
     *
     * @return \Stripe\StripeObject object containing the response from the API
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function deauthorize(array $clientId = null, array|string $opts = null): StripeObject
    {
        $params = [
            'client_id' => $clientId,
            'stripe_user_id' => $this->id,
        ];

        return OAuth::deauthorize($params, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return array|Collection|StripeObject
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function persons(array $params = null, array|string $opts = null): Collection|StripeObject|array
    {
        $url = $this->instanceUrl() . '/persons';
        list($response, $opts) = $this->_request('get', $url, $params, $opts);
        $obj = Util\Util::convertToStripeObject($response, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Account the rejected account
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public function reject(array $params = null, array|string $opts = null): static
    {
        $url = $this->instanceUrl() . '/reject';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);

        return $this;
    }

    /*
     * Capabilities methods
     * We can not add the capabilities() method today as the Account object already has a
     * capabilities property which is a hash and not the sub-list of capabilities.
     */

    const PATH_CAPABILITIES = '/capabilities';

    /**
     * @param string $id the ID of the account on which to retrieve the capabilities
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Collection|StripeObject
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public static function allCapabilities(string $id, array $params = null, array|string $opts = null): Collection|StripeObject
    {
        return self::_allNestedResources($id, static::PATH_CAPABILITIES, $params, $opts);
    }

    /**
     * @param string $id the ID of the account to which the capability belongs
     * @param string $capabilityId the ID of the capability to retrieve
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Capability|StripeObject
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public static function retrieveCapability(string $id, string $capabilityId, array $params = null, array|string $opts = null): StripeObject|Capability
    {
        return self::_retrieveNestedResource($id, static::PATH_CAPABILITIES, $capabilityId, $params, $opts);
    }

    /**
     * @param string $id the ID of the account to which the capability belongs
     * @param string $capabilityId the ID of the capability to update
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Capability|StripeObject
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public static function updateCapability(string $id, string $capabilityId, array $params = null, array|string $opts = null): StripeObject|Capability
    {
        return self::_updateNestedResource($id, static::PATH_CAPABILITIES, $capabilityId, $params, $opts);
    }

    const PATH_EXTERNAL_ACCOUNTS = '/external_accounts';

    /**
     * @param string $id the ID of the account on which to retrieve the external accounts
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Collection|StripeObject
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public static function allExternalAccounts(string $id, array $params = null, array|string $opts = null): Collection|StripeObject
    {
        return self::_allNestedResources($id, static::PATH_EXTERNAL_ACCOUNTS, $params, $opts);
    }

    /**
     * @param string $id the ID of the account on which to create the external account
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return BankAccount|Card|StripeObject
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     */
    public static function createExternalAccount(string $id, array $params = null, array|string $opts = null): StripeObject|BankAccount|Card
    {
        return self::_createNestedResource($id, static::PATH_EXTERNAL_ACCOUNTS, $params, $opts);
    }

    /**
     * @param string $id the ID of the account to which the external account belongs
     * @param string $externalAccountId the ID of the external account to delete
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return BankAccount|Card|StripeObject
     * @throws ApiErrorException if the request fails
     */
    public static function deleteExternalAccount(string $id, string $externalAccountId, array $params = null, array|string $opts = null): BankAccount|Card|StripeObject
    {
        return self::_deleteNestedResource($id, static::PATH_EXTERNAL_ACCOUNTS, $externalAccountId, $params, $opts);
    }

    /**
     * @param string $id the ID of the account to which the external account belongs
     * @param string $externalAccountId the ID of the external account to retrieve
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return BankAccount|Card|StripeObject
     * @throws ApiErrorException if the request fails
     */
    public static function retrieveExternalAccount(string $id, string $externalAccountId, array $params = null, array|string $opts = null): BankAccount|Card|StripeObject
    {
        return self::_retrieveNestedResource($id, static::PATH_EXTERNAL_ACCOUNTS, $externalAccountId, $params, $opts);
    }

    /**
     * @param string $id the ID of the account to which the external account belongs
     * @param string $externalAccountId the ID of the external account to update
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return BankAccount|Card|StripeObject
     * @throws ApiErrorException if the request fails
     */
    public static function updateExternalAccount(string $id, string $externalAccountId, array $params = null, array|string $opts = null): BankAccount|Card|StripeObject
    {
        return self::_updateNestedResource($id, static::PATH_EXTERNAL_ACCOUNTS, $externalAccountId, $params, $opts);
    }

    const PATH_LOGIN_LINKS = '/login_links';

    /**
     * @param string $id the ID of the account on which to create the login link
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return LoginLink|StripeObject
     * @throws ApiErrorException if the request fails
     */
    public static function createLoginLink(string $id, array $params = null, array|string $opts = null): LoginLink|StripeObject
    {
        return self::_createNestedResource($id, static::PATH_LOGIN_LINKS, $params, $opts);
    }

    const PATH_PERSONS = '/persons';

    /**
     * @param string $id the ID of the account on which to retrieve the persons
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Collection|StripeObject the list of persons
     * @throws ApiErrorException if the request fails
     */
    public static function allPersons(string $id, array $params = null, array|string $opts = null): Collection|StripeObject
    {
        return self::_allNestedResources($id, static::PATH_PERSONS, $params, $opts);
    }

    /**
     * @param string $id the ID of the account on which to create the person
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Person|StripeObject
     * @throws ApiErrorException if the request fails
     */
    public static function createPerson(string $id, array $params = null, array|string $opts = null): Person|StripeObject
    {
        return self::_createNestedResource($id, static::PATH_PERSONS, $params, $opts);
    }

    /**
     * @param string $id the ID of the account to which the person belongs
     * @param string $personId the ID of the person to delete
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Person|StripeObject
     * @throws ApiErrorException if the request fails
     */
    public static function deletePerson(string $id, string $personId, array $params = null, array|string $opts = null): Person|StripeObject
    {
        return self::_deleteNestedResource($id, static::PATH_PERSONS, $personId, $params, $opts);
    }

    /**
     * @param string $id the ID of the account to which the person belongs
     * @param string $personId the ID of the person to retrieve
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Person|StripeObject
     * @throws ApiErrorException if the request fails
     */
    public static function retrievePerson(string $id, string $personId, array $params = null, array|string $opts = null): Person|StripeObject
    {
        return self::_retrieveNestedResource($id, static::PATH_PERSONS, $personId, $params, $opts);
    }

    /**
     * @param string $id the ID of the account to which the person belongs
     * @param string $personId the ID of the person to update
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Person|StripeObject
     * @throws ApiErrorException if the request fails
     */
    public static function updatePerson(string $id, string $personId, array $params = null, array|string $opts = null): Person|StripeObject
    {
        return self::_updateNestedResource($id, static::PATH_PERSONS, $personId, $params, $opts);
    }
}

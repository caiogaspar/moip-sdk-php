<?php

namespace Moip\Auth;

use Moip\Contracts\Authentication;
use Moip\Exceptions\InvalidArgumentException;
use Requests_Hooks;

/**
 * Class Connect
 */
class Connect implements Authentication
{
    /**
     * Define the type of response to be obtained. Possible values: CODE
     *
     * @const string
     */
    const RESPONSE_TYPE = 'code';

    /**
     * Permission for creation and consultation of ORDERS, PAYMENTS, MULTI ORDERS, MULTI PAYMENTS, CUSTOMERS and consultation of LAUNCHES.
     *
     * @const string
     */
    const RECEIVE_FUNDS = 'RECEIVE_FUNDS';

    /**
     * Permission to create and consult reimbursements of ORDERS, PAYMENTS.
     *
     * @const string
     */
    const REFUND = 'REFUND';

    /**
     * Permission to consult ACCOUNTS registration information.
     *
     * @const string
     */
    const MANAGE_ACCOUNT_INFO = 'MANAGE_ACCOUNT_INFO';

    /**
     * Permission to query balance through the ACCOUNTS endpoint.
     *
     * @const string
     */
    const RETRIEVE_FINANCIAL_INFO = 'RETRIEVE_FINANCIAL_INFO';

    /**
     * Permission for bank transfers or for Moip accounts through the TRANSFERS endpoint.
     *
     * @const string
     */
    const TRANSFER_FUNDS = 'TRANSFER_FUNDS';

    /**
     * Permission to create, change, and delete notification preferences through the PREFERENCES endpoint.
     *
     * @const string
     */
    const DEFINE_PREFERENCES = 'DEFINE_PREFERENCES';

    /**
     * Unique identifier of the application that will be carried out the request.
     *
     * @var string (16)
     */
    private $client_id;

    /**
     * Client Redirect URI
     *
     * @var string (255)
     */
    private $redirect_uri;

    /**
     * Permissions that you want (Possible values depending on the feature.).
     *
     * @var array
     */
    private $scope = [];

    /**
     * @param bool $scope
     */
    public function setScodeAll($scope)
    {
        if (! is_bool($scope)) {
            throw new InvalidArgumentException('$scope deve ser boolean, foi passado ' . gettype($scope));
        }

        if ($scope === false) {
            $this->scope = [];
        } else {
            $this->setReceiveFunds(true)
                ->setRefund(true)
                ->setManageAccountInfo(true)
                ->setRetrieveFinancialInfo(true)
                ->setTransferFunds(true)
                ->setDefinePreferences(true);
        }

    }

    /**
     * Permission for creation and consultation of ORDERS, PAYMENTS, MULTI ORDERS, MULTI PAYMENTS, CUSTOMERS and consultation of LAUNCHES.
     *
     * @param  bool $receive_funds
     *
     * @return \Moip\Auth\Connect $this
     *
     * @throws \Moip\Exceptions\InvalidArgumentException
     */
    public function setReceiveFunds($receive_funds)
    {
        if (! is_bool($receive_funds)) {
            throw new InvalidArgumentException('$receive_funds deve ser boolean, foi passado ' . gettype($receive_funds));
        }

        if ($receive_funds === true) {
            $this->setScope(self::RECEIVE_FUNDS);
        }

        return $this;
    }

    /**
     * Permission to create and consult reimbursements ofORDERS, PAYMENTS.
     *
     * @param  bool $refund
     *
     * @return \Moip\Auth\Connect $this
     *
     * @throws \Moip\Exceptions\InvalidArgumentException
     */
    public function setRefund($refund)
    {
        if (! is_bool($refund)) {
            throw new InvalidArgumentException('$refund deve ser boolean, foi passado ' . gettype($refund));
        }

        if ($refund === true) {
            $this->setScope(self::RECEIVE_FUNDS);
        }

        return $this;
    }

    /**
     * Permission to consult ACCOUNTS registration information.
     *
     * @param  bool $manage_account_info
     *
     * @return \Moip\Auth\Connect $this
     *
     * @throws \Moip\Exceptions\InvalidArgumentException
     */
    public function setManageAccountInfo($manage_account_info)
    {
        if (! is_bool($manage_account_info)) {
            throw new InvalidArgumentException('$manage_account_info deve ser boolean, foi passado ' . gettype($manage_account_info));
        }

        if ($manage_account_info === true) {
            $this->setScope(self::RECEIVE_FUNDS);
        }

        return $this;
    }

    /**
     * Permission to query balance through the ACCOUNTS endpoint.
     *
     * @param  bool $retrieve_financial_info
     *
     * @return \Moip\Auth\Connect $this
     *
     * @throws \Moip\Exceptions\InvalidArgumentException
     */
    public function setRetrieveFinancialInfo($retrieve_financial_info)
    {
        if (! is_bool($retrieve_financial_info)) {
            throw new InvalidArgumentException('$retrieve_financial_info deve ser boolean, foi passado ' . gettype($retrieve_financial_info));
        }

        if ($retrieve_financial_info === true) {
            $this->setScope(self::RECEIVE_FUNDS);
        }

        return $this;
    }

    /**
     * Permission for bank transfers or for Moip accounts through the TRANSFERS endpoint.
     *
     * @param  bool $transfer_funds
     *
     * @return \Moip\Auth\Connect $this
     *
     * @throws \Moip\Exceptions\InvalidArgumentException
     */
    public function setTransferFunds($transfer_funds)
    {
        if (! is_bool($transfer_funds)) {
            throw new InvalidArgumentException('$transfer_funds deve ser boolean, foi passado ' . gettype($transfer_funds));
        }

        if ($transfer_funds === true) {
            $this->setScope(self::RECEIVE_FUNDS);
        }

        return $this;
    }

    /**
     * Permission to create, change, and delete notification preferences through the PREFERENCES endpoint.
     *
     * @param  bool $define_preferences
     *
     * @return $this
     *
     * @throws \Moip\Exceptions\InvalidArgumentException
     */
    public function setDefinePreferences($define_preferences)
    {
        if (! is_bool($define_preferences)) {
            throw new InvalidArgumentException('$define_preferences deve ser boolean, foi passado ' . gettype($define_preferences));
        }

        if ($define_preferences === true) {
            $this->setScope(self::RECEIVE_FUNDS);
        }

        return $this;
    }

    /**
     * Unique identifier of the application that will be carried out the request.
     *
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Unique identifier of the application that will be carried out the request.
     *
     * @param mixed $client_id
     *
     * @return \Moip\Auth\Connect
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * Client Redirect URI.
     *
     * @return mixed
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }

    /**
     * Client Redirect URI.
     *
     * @param mixed $redirect_uri
     *
     * @return \Moip\Auth\Connect
     */
    public function setRedirectUri($redirect_uri)
    {
        $this->redirect_uri = $redirect_uri;
        return $this;
    }

    /**
     * Permissions that you want (Possible values depending on the feature.).
     *
     * @return mixed
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Permissions that you want (Possible values depending on the feature.).
     *
     * @param array|string $scope
     *
     * @return \Moip\Auth\Connect
     */
    public function setScope($scope)
    {
        $this->scope[] = $scope;

        return $this;
    }

    /**
     * Register hooks as needed
     *
     * This method is called in {@see Requests::request} when the user has set
     * an instance as the 'auth' option. Use this callback to register all the
     * hooks you'll need.
     *
     * @see Requests_Hooks::register
     * @param Requests_Hooks $hooks Hook system
     */
    public function register(Requests_Hooks &$hooks)
    {
        // TODO: Implement register() method.
    }
}

# Simfoni interface for PHP

<a href="https://travis-ci.org/mblsolutions/simfoni-php"><img src="https://travis-ci.org/mblsolutions/simfoni-php.svg" alt="Build Status"></a>

The Simfoni Interface for PHP gives you an API interface into the Simfoni Platform for your PHP applications.

## Contents

- [Integration Applications](#integration-applications)
- [Installation](#installation)
- [Authentication](#authentication)
- [Find Code](#find-code)
- [Code Transactions](#code-transactions)
- [Transaction History](#transaction-history)
- [License](#license)

## Integration Applications

Simfoni provides an interface for the integrator to manage their own set of security credentials. This interface is
available from the `Developers > Manage API tokens` menu item of the Simfoni platform.

 - [Live Integration Applications](https://portal.inspireddeck.co.uk/integration) / [Staging Integration Applications](https://staging-portal.inspireddeck.co.uk/integration)
 - [Live Documentation](https://portal.inspireddeck.co.uk/docs) / [Staging Documentation](https://staging-portal.inspireddeck.co.uk/docs)

## Installation

The recommended way to install Simfoni PHP is through [Composer](https://getcomposer.org/).

```bash
composer require mblsolutions/simfoni-php
```

## Usage

### Authentication

Please Note: Your API credentials (Client ID, Client Secret and access_tokens) carry many permissions. Keep these
credentials secure. Do not share this data in Github, client side code etc... If you believe any of your credentials have
been compromised, within the Simfoni application interface revoke/reset user tokens, client secrets and
encryption keys.

Authentication can be made by passing your Simfoni Application `Client ID`, `Client Secret`,
`Users Email` and `Users Password` to the  authentication password method.

```php
$simfoniAuthentication = new \MBLSolutions\Simfoni\Authentication();

$authentication = $simfoniAuthentication->password(1, 'auth-secret', 'john.doe@exmaple.com', 'password');
```

A successful authentication will return an OAuth response containing access, refresh and user information.

```php
[
    'token_type' => 'Bearer',
    'expires_in' => 31622400,
    'access_token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBmOGMwNDAxZDAy',
    'refresh_token' => 'def5020002eca9ac7875d5d800c195024d7fb702535c0d30a0',
    'user' => [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'role' => 'programme_manager'
    ]
];
```

We recommend this information is stored and reused between requests (the authentication will expire '31622400' seconds
from the moment the authentication is issued).

Use your `access_token` by setting the token in the Simfoni Configuration. The PHP library will automatically
attach this token to each api request (within the current request, each PHP request would need to re-set this token).

```php
\MBLSolutions\Simfoni\Simfoni::setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBmOGMwNDAxZDAy');
```

### Find Code

Before transactions can be issued against product codes, we recommend checking the current state/validity of the code. The
search object should be used to issue this request to Inspired Deck. Search criteria should be one of `serial`,
`pan`, `customer` or `transaction`.

```php
\MBLSolutions\InspiredDeck\InspiredDeck::setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBmOGMwNDAxZDAy');

$search = new \MBLSolutions\InspiredDeck\Search();

$result = $search->code([
    'serial' => 123456789,
    'pan' => null,
    'customer' => null,
    'transaction' => null,
]);
```

A successful request will show information about the code.

```php
[
    'data' => [
        'activation_date' => null,
        'asset' => "Example Gift Card",
        'balance' => 0,
        'created' => "2016-08-31T12:36:34+00:00",
        'currency_code' => "GBP",
        'currency_decimals' => 2,
        'display' => "12345*******6799",
        'expiration_date' => "2021-12-16T00:00:00+00:00",
        'profile' => "Example Codes",
        'serial' => 123456789,
        'sku' => "GIFT_CARD",
        'status' => "active",
        'type' => "physical",
        'updated' => "2019-10-30T11:35:49+00:00",
        'valid_from' => null,
        'valid_to' => null,
    ]
];
```

### Code Transactions

Code transactions can be performed on a number of API objects included within this package (a full list can be located in
the src directory e.g. /src/Balance.php).

```php
\MBLSolutions\InspiredDeck\InspiredDeck::setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBmOGMwNDAxZDAy');

$search = new \MBLSolutions\InspiredDeck\Credit();

$result = $search->credit([
    'serial' => 12345678,
    'amount' => 1000,
    'reference' => 'TEST-REF-1'
]);
```

A successful transaction will return updated information about the code (see updated balance).

```php
[
    'data' => [
        'activation_date' => null,
        'asset' => "Example Gift Card",
        'balance' => 1000,
        'created' => "2016-08-31T12:36:34+00:00",
        'currency_code' => "GBP",
        'currency_decimals' => 2,
        'display' => "12345*******6799",
        'expiration_date' => "2021-12-16T00:00:00+00:00",
        'profile' => "Example Codes",
        'serial' => 123456789,
        'sku' => "GIFT_CARD",
        'status' => "active",
        'type' => "physical",
        'updated' => "2019-10-30T11:35:49+00:00",
        'valid_from' => null,
        'valid_to' => null,
    ]
];
```

### Transaction History

Code transaction history can be obtained using the Transaction History object.

```php
\MBLSolutions\InspiredDeck\InspiredDeck::setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBmOGMwNDAxZDAy');

$search = new \MBLSolutions\InspiredDeck\TransactionHistory();

$page = 1;
$limit = 5;

$result = $search->all(12345678, $page, $limit);
```

Transaction history for the requested code will be returned.

```php
[
    'data' => [
        [
            'action' => "search",
            'action_name' => "Find Code",
            'amount' => 1000,
            'comment' => null,
            'currency_code' => "GBP",
            'currency_decimals' => 2,
            'date' => "2020-10-01T10:40:40+00:00",
            'external_ref' => null,
            'origin_ref' => null,
            'reference' => "TEST-REF-1",
            'reversed' => false,
            'serial' => 123456789,
            'user' => "John Doe"
        ],
        [
            'action' => "search",
            'action_name' => "Find Code",
            'amount' => 0,
            'comment' => null,
            'currency_code' => "GBP",
            'currency_decimals' => 2,
            'date' => "2020-10-01T10:40:33+00:00",
            'external_ref' => null,
            'origin_ref' => null,
            'reference' => "ID-1601548826005",
            'reversed' => false,
            'serial' => 123456789,
            'user' => "John Doe"
        ]
    ]
];
```

### License

Inspired Deck Interface for PHP is free software distributed under the terms of the MIT license.

A contract/subscription to Inspired Deck is required to make use of this package, for more information contact
[MBL Solutions](mailto:support@mblsolutions.co.uk)
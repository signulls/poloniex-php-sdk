## Poloniex PHP API Client

[![Build Status](https://travis-ci.org/signulls/poloniex-php-sdk.svg?branch=master)](https://travis-ci.org/signulls/poloniex-php-sdk)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/e0c433d80a734031ac74c1867c9aeba1)](https://www.codacy.com/app/Signulls/poloniex-php-sdk?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=signulls/poloniex-php-sdk&amp;utm_campaign=Badge_Grade)
[![Maintainability](https://api.codeclimate.com/v1/badges/8d6540373ac975c83ccb/maintainability)](https://codeclimate.com/github/signulls/poloniex-php-sdk/maintainability)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/e0c433d80a734031ac74c1867c9aeba1)](https://www.codacy.com/app/Signulls/poloniex-php-sdk?utm_source=github.com&utm_medium=referral&utm_content=signulls/poloniex-php-sdk&utm_campaign=Badge_Coverage)
[![License](https://poser.pugx.org/signulls/poloniex-php-sdk/license)](https://packagist.org/packages/signulls/poloniex-php-sdk)

![logo](http://www.obzorbtc.com/wp-content/uploads/2015/12/Poloniex-logo-800px.png) 

This repository provides PHP client for Poloniex API.

### Donate

I gave for you a nice library for communication between your PHP project and Poloniex API. So, I will be so happy if you send me some coins for beer :)

- **BTC**: 12HmN3pjD6AsN1rX4EQ1FXZDbHpeXyt7u9
- **ETH**: 0xe18b26070cc692e8086ea169d9b3dff35a53f92c

### Prerequisites

- PHP 7.1 or later
- Redis (for tracking your requests to Poloniex API Endpoint)

### Installation

Setup this repository with Composer, just add the following to your composer.json:
```markdown
    "require": {
        "signulls/poloniex-php-sdk": "^1.0"
    }
```

Or, of course, you can use command line like a boss:
```markdown
composer require signulls/poloniex-php-sdk
```
This library is available on [Packagist](https://packagist.org/packages/signulls/poloniex-php-sdk).

## Basic usage

**Create Poloniex client**
```markdown
$logger = new Logger(); // Symfony based logger
$callHistoryManager = new RedisCallHistory($redis); // or any other implementation of CallHistoryInterface
$poloniexClient = new PoloniexClient($logger, $callHistoryManager);
```

**Make calls to public API**
```markdown
$serializer = new Serializer(); // Symfony based serializer
$publicApi = new PublicApi($poloniexClient, $serializer);
$ticker = $publicApi->returnTicker();
```
**Make calls to Trade API**
```markdown
$nonceProvider = new RedisNonceProvider(); // or any other implementation of NonceProviderInterface
$tradingApi = new TradingApi($poloniexClient, $serializer, $nonceProvider);
$tradingApi->setApiKey(new ApiKey('key', 'secret'));
$balances = $tradingApi->returnBalances();
```

## Versioning

For transparency into our release cycle and in striving to maintain backward compatibility, project is maintained under [the Semantic Versioning guidelines](http://semver.org/).
Sometimes we screw up, but we'll adhere to those rules whenever possible.

## Creator

**Chasovskih Grisha**
<chasovskihgrisha@gmail.com>
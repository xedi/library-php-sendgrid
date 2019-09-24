[![](https://github.com/xedi/library-php-sendgrid/workflows/Linting/badge.svg)](https://github.com/xedi/library-php-sendgrid/actions)
[![](https://github.com/xedi/library-php-sendgrid/workflows/Unit%20Testing/badge.svg)](https://github.com/xedi/library-php-sendgrid/actions)
[![Dependabot Status](https://api.dependabot.com/badges/status?host=github&identifier=208819381)](https://app.dependabot.com/accounts/xedi/repos/208819381)
[![Packagist](https://img.shields.io/packagist/v/xedi/sendgrid.svg?logo=composer&labelColor=282d33&logoColor=white)](https://packagist.org/packages/xedi/sendgrid)

# Table of Contents

* [Installation](#installation)
* [Quick Start](#quick-start)
* [About](#about)
* [Feature Requests](#feature-requests)
* [Security Vulnerabilities](#security-vulnerabilities)

<a name="Installation"></a>
# Installation

### Prerequisites

* PHP 7.1+
* A SendGrid account and [API Key][SENDGRID_API_KEY]

### Install Package

Add [XEDI][XEDI] SendGrid to your `composer.json` file either manually or using `composer require`.

```json
{
    "require": {
        "xedi/sendgrid": "^1"
    }
}
```

```shell
composer require xedi/sendgrid
```

**We recommend the later option, let composer do it's thing**

<a name="quick-start"></a>
# Quick Start

```php
<?php
    require 'vendor/autoload.php';

    use Xedi\SendGrid\Contracts\Exception as SendGridException;
    use Xedi\SendGrid\SendGrid;

    SendGrid::setClient(
        SendGrid::getApiClient($api_key);
    );

    ($mailable = SendGrid::prepareMail())
        ->setSender('you@email.com', 'Joe Blogs')
        ->setSubject('Checkout XEDI\'s SendGrid libray!')
        ->addTextContent('Hey,\n\rI found this great SendGrid library!')
        ->addHtmlContent('<body>Hey,<br/>I found this great SendGrid library!</body>')
        ->addRecipient('john.smith@email.com', 'John Smith');

    try {
        SendGrid::send($mailable);
    } catch (SendGridException $exception) {
        echo 'Caught exception: ' . (string) $exception;
    }
```

<a name="about"></a>
# About

This library uses [SendGrids v3 HTTP API][SENDGRID_API_DOCS]. It builts on some of the limitations of the "official" library such as:

* Interacts with cURL directly limiting your ability to intercept requests during tests.
* Exceptions aren't specific to the returned error.

We employ [GuzzleHttp][GUZZLEHTTP] to act as our cURL wrapper off-loading responsibility of processing HTTP requests. Guzzle 6 provides a great utility for intercepting HTTP requests made through it's client; for more details [click here][GUZZLEHTTP_TESTING].

SendGrid only returns one error code if there is a problem with your payload! This is because SendGrid's API is not RESTful. Our library will attempt to provide contextual exceptions such as `Xedi\SendGrid\Exceptions\Domain\SubjectException`, which would be thrown if SendGrid reports an issue with your subject field.

All exceptions can be identified using our `ExceptionContract` which all exceptions implement.

<a name="feature-requests"></a>
# Feature Requests

This library was developed for an in-house project, and it's features will grow as our requirements change. **However**, if there is something we don't support please raise a GitHub issue.

<a name="security-vulnerabilities"></a>
# Security Vulnerabilities

We take security very seriously. If you spot something, please let us know by emailing use at [development@xedi.com][SECURITY_REPORTING_LINK].

<!-- ############################# Reference Links ####################################### -->

[XEDI]: https://xedi.com
[GUZZLEHTTP]: http://docs.guzzlephp.org
[GUZZLEHTTP_TESTING]: http://docs.guzzlephp.org/en/stable/testing.html
[SENDGRID_API_DOCS]: https://sendgrid.com/docs/api-reference/
[SENDGRID_API_KEY]: https://app.sendgrid.com/settings/api_keys
[SECURITY_REPORTING_LINK]: mailto:development@xedi.com?subject=Security%20Vulnerability%20Found%20-%20Xedi%2FSendGrid

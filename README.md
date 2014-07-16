# BriteVerify API Client #

[BriteVerify](http://www.briteverify.com/) is a service for verifying email addresses. This library is a client for interacting with their real-time API.


# Usage

Use the verify() method to validate an email.

```php
include 'vendor/autoload.php';

$client = new REINetwork\BriteVerify\Client('1111-2222-3333-4444');
$response = $this->client->verify('johndoe@briteverify.com');

$response->isValid();  //false
$response->isInvalid();  //true
$response->isAcceptAll();  //false
$response->isUnknown();  //false
$response->isDisposable(); //false
$response->isRoleAddress();  //false
```


# Documentation

* https://www.briteverify.com/

# Kourses PHP bindings

The Kourses PHP library provides access to Kourses API from applications written in PHP. It includes a pre-defined set of classes for API resources such as `members`, `products` and `permissions`.

## Requirements

PHP 5.6.0 and later.

## Installation

You can install the library via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require lukapeharda/kourses-php
```

To use the library, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Getting Started

Visit Kourses [Settings / API keys](https://app.kourses.com/settings/api-keys) page and generate API key. Each key is tied to only one of your website. Copy your API key as you won't be able to access the token later on.

API key should go in HTTP `Authorization` header as a bearer token:

```
Authorization: Bearer GENERATED_API_TOKEN
```

### First initialize a client and set the token

```php
$kourses = new Kourses\Client();
$kourses->setApiKey('GENERATED_API_TOKEN');
```

If you want to access beta environment of Kourses app, use `setApiBaseUrl` method to change the URL:

```php
$kourses->setApiBaseUrl('https://app.kourses-beta.com/api/');
```

### Fetching products

To fetch all published products use `products` resource and the `all` method:

```php
$products = $kourses->products->all();
```

Returned data will be paginated (default number of products per page is 100). In order to change number of products per page or current page use `page` and `per_page` params (respectively):

```php
$products = $kourses->products->all([
    'per_page' => 10,
    'page' => 2,
]);
```

You can iterate over `$products` to get `Kourses\Product` entities.

There are several helpful methods to handle pagination:

```php
$products->getCurrentPage(); // returns current page number
$products->getLastPage(); // returns last page number
$products->getTotal(); // returns total number of products
$products->getFrom(); // returns current page items range start
$products->getTo(); // returns current page items range end
$products->getPerPage(); // returns number of products per page
```

### Creating members

Use `create` method on the `members` resource:

```php
$member = $kourses->members->create([
    'email' => 'john.doe@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
]);
```

If member was found (based on their email address) they will be updated with the rest of the given data.

You may set a list of `products` for which the member should get access to in the same API call:

```php
$member = $kourses->members->create([
    'email' => 'john.doe@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'products' => ['PRODUCT#1', 'PRODUCT#2'],
]);
```

#### Sending activation email

By default, when new member is created they will be sent an activation email.

To disable this set `send_activation_notification` to `0`:

```php
$member = $kourses->members->create([
    'email' => 'john.doe@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'send_activation_notification' => 0,
]);
```

#### Setting permission expiry dates

For each product you can set future expiry date using `products_access_ends_at` param. Date given needs to be in `YYYY-MM-DD` or `YYYY-MM-DD hh:mm:ss` format:

```php
$member = $kourses->members->create([
    'email' => 'john.doe@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'products' => ['PRODUCT#1', 'PRODUCT#2'],
    'products_access_ends_at' => [
        'PRODUCT#1' => '2030-04-05',
    ],
]);
```

#### Skipping drip schedule

For each product you disable drip schedule using `products_skip_drip_schedule` param:

```php
$member = $kourses->members->create([
    'email' => 'john.doe@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'products' => ['PRODUCT#1', 'PRODUCT#2'],
    'products_skip_drip_schedule' => [
        'PRODUCT#1' => 0,
    ],
]);
```

By default it will honor the set drip schedule.

### Fetching allowed products for a member

Use `memberProducts` resource and `all` method to fetch a list of all products that member was granted access to:

```php
$products = $kourses->memberProducts->all([
    'member' => 'MEMBER#1',
]);
```

You can even use member's email address to fetch the products:

```php
$products = $kourses->memberProducts->all([
    'member' => 'john.doe@example.com',
]);
```

Returned data will be paginated (default number of products per page is 100). In order to change number of products per page or current page use `page` and `per_page` params (respectively):

```php
$products = $kourses->memberProducts->all([
    'member' => 'MEMBER#1',
    'per_page' => 10,
    'page' => 2,
]);
```

### Grant a permission

To grant a permission you need to call `create` method on `permissions` resource and provide a member ID (or their email address) and a product ID:

```php
$status = $kourses->permissions->create([
    'member' => 'MEMBER#1',
    'product' => 'PRODUCT#1',
]);
```

You can add and extra `ends_at` param to specify permission expiry date. Date given needs to be in `YYYY-MM-DD` or `YYYY-MM-DD hh:mm:ss` format:

```php
$status = $kourses->permissions->create([
    'member' => 'MEMBER#1',
    'product' => 'PRODUCT#1',
    'ends_at' => '2030-04-05',
]);
```

If you wish to skip drip schedule set for a given products use `skip_drip_schedule` and set it to `0`:

```php
$status = $kourses->permissions->create([
    'member' => 'MEMBER#1',
    'product' => 'PRODUCT#1',
    'skip_drip_schedule' => 0,
]);
```

By default the set drip schedule will be honored.

### Revoke a permission

To revoke a permission you need to call `delete` method on `permissions` resource and provide a member ID (or their email address) and a product ID:

```php
$status = $kourses->permissions->delete([
    'member' => 'MEMBER#1',
    'product' => 'PRODUCT#1',
]);
```

You can add and extra `ends_at` param to specify permission expiry date. Date given needs to be in `YYYY-MM-DD` or `YYYY-MM-DD hh:mm:ss` format:

```php
$status = $kourses->permissions->delete([
    'member' => 'MEMBER#1',
    'product' => 'PRODUCT#1',
    'ends_at' => '2030-04-05',
]);
```

## Documentation

Check out [examples](https://github.com/lukapeharda/kourses-php/tree/main/examples) folder for some basic use cases. Full documentation is available on [developer.kourses.com](https://developer.kourses.com).

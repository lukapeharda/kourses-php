# Kourses PHP bindings

The Kourses PHP library provides access to Kourses API from applications written in PHP. It includes a pre-defined set of classes for API resources such as `members`, `memberships` and `permissions`.

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
$kourses = new KoursesPhp\Client();
$kourses->setApiKey('GENERATED_API_TOKEN');
```

If you want to access beta environment of Kourses app, use `setApiBaseUrl` method to change the URL:

```php
$kourses->setApiBaseUrl('https://app.kourses-beta.com/api/');
```

### Fetching memberships

To fetch all published memberships use `memberships` resource and the `all` method:

```php
$memberships = $kourses->memberships->all();
```

Returned data will be paginated (default number of memberships per page is 100). In order to change number of memberships per page or current page use `page` and `per_page` params (respectively):

```php
$memberships = $kourses->memberships->all([
    'per_page' => 10,
    'page' => 2,
]);
```

You can iterate over `$memberships` to get `KoursesPhp\Membership` entities.

There are several helpful methods to handle pagination:

```php
$memberships->getCurrentPage(); // returns current page number
$memberships->getLastPage(); // returns last page number
$memberships->getTotal(); // returns total number of memberships
$memberships->getFrom(); // returns current page items range start
$memberships->getTo(); // returns current page items range end
$memberships->getPerPage(); // returns number of memberships per page
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

You may set a list of `memberships` for which the member should get access to in the same API call:

```php
$member = $kourses->members->create([
    'email' => 'john.doe@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'memberships' => ['MEMBERSHIP#1', 'MEMBERSHIP#2'],
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

For each membership you can set future expiry date using `memberships_access_ends_at` param. Date given needs to be in `YYYY-MM-DD` or `YYYY-MM-DD hh:mm:ss` format:

```php
$member = $kourses->members->create([
    'email' => 'john.doe@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'memberships' => ['MEMBERSHIP#1', 'MEMBERSHIP#2'],
    'memberships_access_ends_at' => [
        'MEMBERSHIP#1' => '2030-04-05',
    ],
]);
```

#### Skipping drip schedule

For each membership you can disable drip schedule using `memberships_skip_drip_schedule` param:

```php
$member = $kourses->members->create([
    'email' => 'john.doe@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'memberships' => ['MEMBERSHIP#1', 'MEMBERSHIP#2'],
    'memberships_skip_drip_schedule' => [
        'MEMBERSHIP#1' => 0,
    ],
]);
```

#### Running membership's email integrations

For each membership you can enable running of email integrations using `memberships_run_email_integrations` param:

```php
$member = $kourses->members->create([
    'email' => 'john.doe@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'memberships' => ['MEMBERSHIP#1', 'MEMBERSHIP#2'],
    'memberships_run_email_integrations' => [
        'MEMBERSHIP#1' => 1,
    ],
]);
```

By default it will honor the set drip schedule.

### Fetching allowed memberships for a member

Use `memberMemberships` resource and `all` method to fetch a list of all memberships that member was granted access to:

```php
$memberships = $kourses->memberMemberships->all([
    'member' => 'MEMBER#1',
]);
```

You can even use member's email address to fetch the memberships:

```php
$memberships = $kourses->memberMemberships->all([
    'member' => 'john.doe@example.com',
]);
```

Returned data will be paginated (default number of memberships per page is 100). In order to change number of memberships per page or current page use `page` and `per_page` params (respectively):

```php
$memberships = $kourses->memberMemberships->all([
    'member' => 'MEMBER#1',
    'per_page' => 10,
    'page' => 2,
]);
```

### Generate one-click login link for a member

Use `memberLoginLink` resource and its `create` method to generate temporary signed login link.

```php
$loginLink = $koures->memberLoginLink->create([
    'member' => 'MEMBER#1',
]);
```

Returned `$loginLink` object will have a `login_link` property which you can serve to your user in order for them to log in. `expires_at` property which holds the timestamp (ISO-8601) then the login link will expire.

Signed link will expired in 5 mins (300 seconds).

You can even use member's email address to generate the link:

```php
$loginLink = $kourses->memberLoginLink->create([
    'member' => 'john.doe@example.com',
]);
```

If you wish to redirect the member after successful login specify a `redirect` param with relative path:

```php
$loginLink = $kourses->memberLoginLink->create([
    'member' => 'john.doe@example.com',
    'redirect' => 'account/profile',
]);
```


### Grant a permission

To grant a permission you need to call `create` method on `permissions` resource and provide a member ID (or their email address) and a membership ID:

```php
$status = $kourses->permissions->create([
    'member' => 'MEMBER#1',
    'membership' => 'MEMBERSHIP#1',
]);
```

You can add and extra `ends_at` param to specify permission expiry date. Date given needs to be in `YYYY-MM-DD` or `YYYY-MM-DD hh:mm:ss` format:

```php
$status = $kourses->permissions->create([
    'member' => 'MEMBER#1',
    'membership' => 'MEMBERSHIP#1',
    'ends_at' => '2030-04-05',
]);
```

If you wish to skip drip schedule set for a given membership use `skip_drip_schedule` and set it to `0`:

```php
$status = $kourses->permissions->create([
    'member' => 'MEMBER#1',
    'membership' => 'MEMBERSHIP#1',
    'skip_drip_schedule' => 0,
]);
```

If you wish to run email integrations for a given membership use `run_email_intgrations` and set it to `1`:

```php
$status = $kourses->permissions->create([
    'member' => 'MEMBER#1',
    'membership' => 'MEMBERSHIP#1',
    'run_email_intgrations' => 0,
]);
```

By default the set drip schedule will be honored.

### Revoke a permission

To revoke a permission you need to call `delete` method on `permissions` resource and provide a member ID (or their email address) and a membership ID:

```php
$status = $kourses->permissions->delete([
    'member' => 'MEMBER#1',
    'membership' => 'MEMBERSHIP#1',
]);
```

You can add and extra `ends_at` param to specify permission expiry date. Date given needs to be in `YYYY-MM-DD` or `YYYY-MM-DD hh:mm:ss` format:

```php
$status = $kourses->permissions->delete([
    'member' => 'MEMBER#1',
    'membership' => 'MEMBERSHIP#1',
    'ends_at' => '2030-04-05',
]);
```

## Documentation

Check out [examples](https://github.com/lukapeharda/kourses-php/tree/main/examples) folder for some basic use cases. Full documentation is available on [developer.kourses.com](https://developer.kourses.com).

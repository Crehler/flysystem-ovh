# Flysystem Adapter for **OVH** Object Storage.

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Installation

```bash
composer require crehler/flysystem-ovh
```

## Usage

See configuration section for credential details.

```php
use Crehler\Flysystem\OvhObjectStorage;
use Crehler\Flysystem\OvhObjectStorageAdapter as Adapter;
use League\Flysystem\Filesystem;

$client = new OvhObjectStorage([
   'username'  => ':username',
   'password'  => ':password',
   'tenantId'  => ':tenantId',
]);

$store = $client->objectStoreService('swift', 'SBG1');
$container = $store->getContainer('flysystem');

$filesystem = new Filesystem(new Adapter($container));
```

Alternatively:

```php
use Crehler\Flysystem\OvhObjectStorage;
use Crehler\Flysystem\OvhObjectStorageAdapter as Adapter;
use Crehler\Flysystem\Filesystem;

$options = [
    'username'  => ':username',
    'password'  => ':password',
    'tenantId'  => ':tenantId',
    'container' => 'flysystem',
    'region'    => 'SBG1',
];

$client = new OvhObjectStorage($options);

$filesystem = new Filesystem(new Adapter($client->getContainer()));
```

***

<sup>Based on https://github.com/engineor/flysystem-runabove<sup>

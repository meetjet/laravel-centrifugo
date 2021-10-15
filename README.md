# Laravel Centrifugo

[![Latest Version on Packagist](https://img.shields.io/packagist/v/meetjet/laravel-centrifugo.svg?style=flat-square)](https://packagist.org/packages/meetjet/laravel-centrifugo)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/meetjet/laravel-centrifugo/run-tests?label=tests)](https://github.com/meetjet/laravel-centrifugo/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/meetjet/laravel-centrifugo/Check%20&%20fix%20styling?label=code%20style)](https://github.com/meetjet/laravel-centrifugo/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/meetjet/laravel-centrifugo.svg?style=flat-square)](https://packagist.org/packages/meetjet/laravel-centrifugo)

## Features
- Compatible with latest [Centrifugo 3.0.3](https://github.com/centrifugal/centrifugo/releases/tag/v3.0.3) 
- Contains instructions and configuration file for setting up with Laravel Sail

## Requirements
- PHP >= 7.3
- Laravel 7.30.4 - 8
- Guzzle 6 - 7
- Centrifugo Server 3.0.3 or newer (see [here](https://github.com/centrifugal/centrifugo))

## Installation

You can install the package via composer:
```bash
composer require meetjet/laravel-centrifugo
```

Open your config/broadcasting.php and add new connection like this:
```php
        'centrifugo' => [
            'driver' => 'centrifugo',
            'secret'  => env('CENTRIFUGO_SECRET'),
            'apikey'  => env('CENTRIFUGO_APIKEY'),
            'url'     => env('CENTRIFUGO_URL', 'http://localhost:8000'), // Centrifugo server api url
            'verify'  => env('CENTRIFUGO_VERIFY', false), // Verify host ssl if centrifugo uses this
            'ssl_key' => env('CENTRIFUGO_SSL_KEY', null), // Self-Signed SSl Key for Host (require verify=true)
        ],
```

Also, you should add these two lines to your .env file:
```
CENTRIFUGO_SECRET=token_hmac_secret_key-from-centrifugo-config
CENTRIFUGO_APIKEY=api_key-from-centrifugo-config
CENTRIFUGO_URL=http://localhost:8000
```

These lines are optional:
```
CENTRIFUGO_SSL_KEY=/etc/ssl/some.pem
CENTRIFUGO_VERIFY=false
```

Then change `BROADCAST_DRIVER` setting in .env file:
```
BROADCAST_DRIVER=centrifugo
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Meetjet\LaravelCentrifugo\LaravelCentrifugoServiceProvider" --tag="laravel-centrifugo-config"
```

This is the contents of the published config file:
```php
return [
];
```

## Setup local Centrifugo server with Laravel Sail
Copy centrifugo config file to project root folder via command:
```bash
php artisan centrifugo:setup
```

Add Centrifugo config block into services section of docker-compose.yml file:
```
centrifugo:
    image: centrifugo/centrifugo:latest
    volumes:
        - ./centrifugo.json:/centrifugo/centrifugo.json
    command: centrifugo -c centrifugo.json
    ports:
        - '8008:8008'
    networks:
        - sail
    ulimits:
        nofile:
            soft: 65535
            hard: 65535
```

Open your .env and change centrifugo api url:
```
CENTRIFUGO_URL=http://centrifugo:8008
```

Restart Laravel Sail.

## Usage

To configure Centrifugo server, read [official documentation](https://centrifugal.github.io/centrifugo/)

For broadcasting events, see [official documentation of Laravel](https://laravel.com/docs/8.x/broadcasting)

### Usage with Centrifugo Client
```php
$centrifugo = new Meetjet\LaravelCentrifugo();

// Send message into channel
$centrifugo->publish('public', ['message' => 'Hello world']);

// Generate connection token
$token = $centrifugo->generateConnectionToken((string)Auth::id(), 0, [
    'name' => Auth::user()->name,
]);

// Generate private channel token
$apiSign = $centrifugo->generatePrivateChannelToken((string)Auth::id(), 'channel', time() + 5 * 60, [
    'name' => Auth::user()->name,
]);

//Get a list of currently active channels.
$centrifugo->channels();

//Get channel presence information (all clients currently subscribed on this channel).
$centrifugo->presence('public');
```

### Usage with Laravel Broadcast feature
```php
<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ServerCreated implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * The user that created the server.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('public');
    }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Zorca Orcinus](https://github.com/zorca)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

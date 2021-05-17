# laravel-google-cloud-storage

A Google Cloud Storage filesystem for Laravel.

[![Latest Stable Version](https://poser.pugx.org/superchairon/laravel-google-cloud-logging/v/stable)](https://packagist.org/packages/superchairon/laravel-google-cloud-logging)
[![License](https://poser.pugx.org/superchairon/laravel-google-cloud-logging/license)](https://packagist.org/packages/superchairon/laravel-google-cloud-logging)
[![Total Downloads](https://poser.pugx.org/superchairon/laravel-google-cloud-logging/downloads)](https://packagist.org/packages/superchairon/laravel-google-cloud-logging)

This package is a driver for logging and error reporting for Google Cloud Platform Stackdriver.

## Installation

```bash
composer require superchairon/laravel-google-cloud-logging
```

Add a new channel in your `logging.php` config

```php
        'stackdriver' => [
            'driver' => 'custom',
            'via' => \SuperChairon\LaravelGoogleCloudLogging\StackdriverChannel::class,
            'logName' => 'my-application-log',
            'labels' => [
                'application' => env('APP_NAME'),
                'environment' => env('APP_ENV'),
                'other labels' => '...',
            ],
            'level' => 'debug',
        ]
```

### Authentication

The Google Client uses a few methods to determine how it should authenticate with the Google API.

If the `GOOGLE_CLOUD_PROJECT` and `GOOGLE_APPLICATION_CREDENTIALS` env vars are set, it will use that.
   ```php
   putenv('GOOGLE_CLOUD_PROJECT=project-id');
   putenv('GOOGLE_APPLICATION_CREDENTIALS=/path/to/service-account.json');
   ```
Otherwise you can set as config
```php
        'stackdriver' => [
            'driver' => 'custom',
            ...
            'projectId' => env('GOOGLE_CLOUD_PROJECT_ID', 'project-id'),
            'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE', '/path/to/service-account.json'),
        ]
```

While running on **Google Cloud Platform** environments such as **Google Compute Engine**, **Google App Engine** and **Google Kubernetes Engine**, no extra work is needed. The Project ID and Credentials and are discovered automatically. Code should be written as if already authenticated.

For more information visit the [Authentication documentation for the Google Cloud Client Library for PHP](https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md) 
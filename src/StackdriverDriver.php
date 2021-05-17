<?php

namespace SuperChairon\LaravelGoogleCloudLogging;

use Monolog\Logger;
use Illuminate\Log\ParsesLogConfiguration;

class StackdriverDriver
{
    use ParsesLogConfiguration;

    public function __invoke($config)
    {
        return new Logger($this->parseChannel($config), [
            new StackdriverHandler(
                $config,
                $this->level($config)
            ),
        ]);
    }

    protected function getFallbackChannelName()
    {
        return 'unknown';
    }
}

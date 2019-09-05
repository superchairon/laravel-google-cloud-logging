<?php

namespace App\Helpers;


use Illuminate\Log\ParsesLogConfiguration;
use Monolog\Logger;

class StackdriverDriver
{
    use ParsesLogConfiguration;

    public function __invoke($config)
    {
        return new Logger($this->parseChannel($config), [
            new StackdriverHandler(
                $config['labels'], $config['logName'], $this->level($config)
            ),
        ]);
    }

    protected function getFallbackChannelName()
    {
        return 'unknown';
    }
}
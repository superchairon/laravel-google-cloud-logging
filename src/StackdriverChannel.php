<?php

namespace SuperChairon\LaravelGoogleCloudLogging;

use Monolog\Logger;
use Illuminate\Log\LogManager;

class StackdriverChannel extends LogManager
{
    /**
     * @param array $config
     *
     * @return Logger
     */
    public function __invoke($config)
    {
        $handler = new StackdriverHandler($config, $this->level($config), $config['bubble'] ?? true);

        return new Logger($this->parseChannel($config), [$this->prepareHandler($handler, $config)]);
    }
}

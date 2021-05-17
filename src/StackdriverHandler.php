<?php

namespace SuperChairon\LaravelGoogleCloudLogging;

use Monolog\Logger;
use Google\Cloud\Logging\LoggingClient;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * StackdriverHandler
 *
 * @author Martin van Dam <martin@code.nl>
 * @author Wouter Monkhorst <wouter@code.nl>
 */
class StackdriverHandler extends AbstractProcessingHandler
{
    /**
     * The Stackdriver logger
     * @var Google\Cloud\Logging\Logger
     */
    private $logger;

    /**
     * StackdriverHandler constructor.
     *
     * @param array $config
     * @param int $level
     * @param bool $bubble
     */
    public function __construct($config, $level = Logger::DEBUG, $bubble = true)
    {
        $logName  = $config['logName'];
        $this->logger = (new LoggingClient($config))->logger($logName, $config);
        parent::__construct($level, $bubble);
    }

    /**
     * Writes the record down to the log of the implementing handler
     */
    protected function write(array $record): void
    {
        // set options, according to Google Stackdirver API documentation
        $options = [
            'severity' => $record['level_name'],
        ];

        // set data, based on the $record array received as parameter from Monolog
        $data = [
            'message' => $record['message'],
        ];
        if ($record['context']) {
            $data['context'] = $record['context'];
        }

        // write the entry
        $entry = $this->logger->entry($data, $options);
        $this->logger->write($entry);
    }
}

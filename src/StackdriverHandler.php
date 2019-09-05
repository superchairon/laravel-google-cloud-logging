<?php

namespace App\Helpers;

use Google\Cloud\Logging\LoggingClient;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

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
     * @param $labels
     * @param $logName
     * @param int $level
     * @param bool $bubble
     */
    public function __construct($labels, $logName, $level = Logger::DEBUG, $bubble = true)
    {
        $loggerOptions = [
            'labels' => $labels
        ];
        $this->logger = (new LoggingClient())->logger($logName, $loggerOptions);
        parent::__construct($level, $bubble);
    }

    /**
     * Writes the record down to the log
     *
     * @param  array $record
     * @return void
     */
    protected function write(array $record)
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

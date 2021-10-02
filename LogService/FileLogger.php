<?php

namespace LogService;

/**
 * Write log to file
 */
class FileLogger implements LoggerInterface
{

    protected const LOG_NAME = 'log.txt';

    protected $fileName;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->fileName = dirname(__FILE__) . '/Logs/' . self::LOG_NAME;
    }

    /**
     * @inheritDoc
     * @param string $message - Log message;
     */
    public function log(string $message) : void
    {
        file_put_contents($this->fileName, $message . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

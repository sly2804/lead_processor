<?php

namespace LogService;

interface LoggerInterface
{
    /**
     * Make logging of data
     */
    public function log(string $message);
}

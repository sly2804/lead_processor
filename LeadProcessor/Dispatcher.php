<?php

namespace LeadProcessor;

use LeadGenerator\Lead;
use LogService\FileLogger;

/**
 * Lead Manager
 */
class Dispatcher
{
    protected $categories;
    protected $enabledCategories;

    /**
     * Constructor
     * @param array $categories
     */
    public function __construct()
    {
        $this->categories = Config::getConfigCategories();
        $this->enabledCategories = Config::getCategories();
    }

    /**
     * lead processing
     * @param Lead $lead
     */
    public function dispatch(Lead $lead) : void
    {
        if ($this->enabledCategories[$lead->categoryName]) {
            $processor = $this->categories[$lead->categoryName] ?? __NAMESPACE__ . '\\Processors\\UnknownProcessor';
            $processor = new $processor();
            $this->log($lead,'start processing lead');
            $result = $processor->handle($lead);
            if ($result) {
                $this->log($lead, 'success');
            }
            else {
                $this->log($lead, 'processing error');
            }
        }
        else {
            $this->log($lead, 'process not active');
        }
    }

    /**
     * logging
     * @param Lead $lead
     * @param string $status
     */
    private function log(Lead $lead, string $status) : void
    {
        $logger = new FileLogger;
        $data = [
            $lead->id,
            $lead->categoryName,
            date('Y-m-d H:i:s'),
            $status,
        ];
        $message = implode(' | ', $data);
        $logger->log($message);
    }
}

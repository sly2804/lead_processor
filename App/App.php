<?php

namespace App;

use LeadGenerator\Generator;
use LeadGenerator\Lead;
use LeadProcessor\Dispatcher;
use LogService\FileLogger;

/**
 * Main application class
 */
class App
{
    /**
     * Maximum number of processes
     */
    const MAX_NUM_PROCESS = 500;
    const NUM_LEAD = 10000;

    /**
     * Does the application have superuser rights?
     */
    const SUPER_USER = false;

    private $logger;
    private $processes;
    private $startTime;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->processes = [];
        $this->logger = new FileLogger;
    }

    /**
     * before starting processing
     */

    private function startProcessing()
    {
        echo "Start processing..." . PHP_EOL;
        $this->logger->log('Start processing');
        $this->startTime = time();
    }

    /**
     * after processing is completed
     */
    private function endProcessing()
    {
        $processingTime = time() - $this->startTime;
        $this->logger->log('End processing');
        echo "End processing! Total time is $processingTime seconds!";
    }

    /**
     * start of application
     */
    public function run() : void
    {
        $this->startProcessing();
        $generator = new Generator;
        $generator->generateLeads(self::NUM_LEAD, function (Lead $lead) {
            if (!$this->createProcess($lead)) {

                $this->closingChild();
                $this->createProcess($lead);
            }
            if (count($this->processes) > self::MAX_NUM_PROCESS) {
                $this->logger->log('The maximum number of processes has been reached, closing');
                $this->closingChild();
            }
        });
        $this->closingChild();
        $this->endProcessing();
    }

    /**
     * create process for lead processing
     * @param Lead $lead
     */
    private function createProcess(Lead $lead) : bool
    {
        $pid = pcntl_fork();
        if ($pid == -1) {
            $this->logger->log('Critical Error when processing lead, lead id = ' . $lead->id);
            return false;
        }
        if ($pid) {
            //parent
            if (self::SUPER_USER) pcntl_setpriority(2);
            $this->processes[] = $pid;
        } else {
            //child
            if (self::SUPER_USER) pcntl_setpriority(1);
            $dispatcher = new Dispatcher;
            $dispatcher->dispatch($lead);
            exit();
        }
        return true;
    }

    /**
     * closing all child process
     */
    private function closingChild() : void
    {
        while(count($this->processes) > 0) {
            foreach($this->processes as $key => $pid) {
                $res = pcntl_waitpid($pid, $status, WNOHANG);

                if($res == -1 || $res > 0)
                    unset($this->processes[$key]);
            }
        }
    }
}

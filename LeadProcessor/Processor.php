<?php

namespace LeadProcessor;

use LeadGenerator\Lead;

/**
 * Processor for handling lead
 */
class Processor implements ProcessorInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Lead $lead) : bool
    {
        // имитируем ошибку при обработке в 5% случаев.
        if (rand(0,19)) {
            sleep(2);
            return true;
        }
        else {
            return false;
        }
    }
}

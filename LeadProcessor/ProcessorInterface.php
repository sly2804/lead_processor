<?php

namespace LeadProcessor;

use LeadGenerator\Lead;

interface ProcessorInterface
{
    /**
     * processing lead
     */
    public function handle(Lead $lead);
}

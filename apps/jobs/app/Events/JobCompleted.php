<?php

namespace App\Events;

class JobCompleted extends Event
{
    public $processingTime = null;
    /**
     * Create a new event instance.
     * @param $runtime int
     * @return void
     */
    public function __construct(int $runtime)
    {
        $this->processingTime = $runtime;
    }
}

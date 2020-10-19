<?php

namespace App\Listeners;

use App\Events\ExampleEvent;
use App\Events\JobCompleted;
use Hungtruong\JobModel\JobStatModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class JobCompletedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\JobCompleted  $event
     * @return void
     */
    public function handle(JobCompleted $event)
    {
        $jobStat = JobStatModel::orderBy('created_at', 'asc')->first();
        $jobStat->increment('completed_job_count');
        $jobStat->increment('total_processing_time', $event->processingTime);
        $jobStat->save();
    }
}

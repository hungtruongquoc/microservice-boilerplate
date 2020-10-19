<?php

namespace App\Http\Controllers;

use App\Events\JobCompleted;
use Carbon\Carbon;
use Hungtruong\JobModel\JobModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class ProcessorController extends Controller
{
    private $id = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    //
    public function run($jobId)
    {
        // Creates a random seed for processor id
        srand(floor(time() / 60 * 60 * 24));
        try {
            // Gets the job from the database
            $jobInfo = JobModel::where('id', $jobId)->whereNull('started_at')->whereNull('processor_id')->first();
            $jobInfo->started_at = Carbon::now();
            $jobInfo->processor_id = rand();
            // Saves these information to prevent other processors from taking the job
            $jobInfo->save();
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'code' => $exception->getCode()], 500);
        }
        // Perform the command
        try {
            $result = exec($jobInfo->command, $output, $status);
            $jobInfo->success = 0 === $status && !is_null($result);
            $jobInfo->completed_at = Carbon::now();
            $jobInfo->save();
            // Emits event for updating stats
            $end = new Carbon($jobInfo->completed_at);
            $start = new Carbon($jobInfo->started_at);
            event(new JobCompleted($end->diffInSeconds($start)));
            return response()->json(['job' => $jobInfo], 200);
        } catch (\Exception $exception) {
            $jobInfo->started_at = null;
            $jobInfo->processor_id = null;
            $jobInfo->success = null;
            $jobInfo->completed_at = null;
            $jobInfo->save();
            return response()->json(['message' => $exception->getMessage(), 'code' => $exception->getCode()], 500);
        }
    }
}

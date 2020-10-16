<?php


namespace App\Http\Controllers;


use Hungtruong\JobModel\JobModel;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        try {
            $validatedData = $this->validate($request, [
                'command' => 'required',
                'submitter_id' => 'required',
            ]);
            // Turns the single command into an array to be standardized
            if (!is_array($validatedData['command'])) {
                $validatedData['command'] = [$validatedData['command']];
            }
            // Uses reduce to create an array of jobs
            $newJobs = collect($validatedData['command'])->reduce(function($collection, $item) use ($validatedData) {
                if (!is_null($item) && '' !== $item) {
                    // Creates an array of jobs from the input data by combining all params with each command
                    $job = array_merge(['command' => $item], collect($validatedData)->except(['command'])->toArray());
                    // Saves jobs to database
                    $collection[] = JobModel::create($job);
                }
                return $collection;
            }, []);
            return $this->createSuccessResponse([
                'jobs' => $newJobs,
                'input' => $validatedData
            ]);
        }
        catch(\Exception $exception) {
            return $this->createErrorResponse($exception);
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatus(int $id) {
        try {
            return $this->createSuccessResponse(['job' => JobModel::find($id)->append('status')->toArray()]);
        }
        catch(\Exception $exception) {
            return $this->createErrorResponse($exception);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNextJob() {
        try {
            $nextJob = JobModel::whereNull('started_at')->orderBy('created_at', 'asc')->first();
            return $this->createSuccessResponse(['job' => $nextJob]);
        }
        catch(\Exception $exception) {
            return $this->createErrorResponse($exception);
        }
    }
}

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
            $newJob = JobModel::create($validatedData);
            return $this->createSuccessResponse(['job' => $newJob, 'input' => $validatedData]);
        }
        catch(\Exception $exception) {
            return $this->createErrorResponse($exception);
        }
    }

    public function getStatus(int $id) {
        try {
            return $this->createSuccessResponse(['job' => JobModel::find($id)]);
        }
        catch(\Exception $exception) {
            return $this->createErrorResponse($exception);
        }
    }

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

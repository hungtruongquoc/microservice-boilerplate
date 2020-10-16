<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    const STATUS_CODE_SERVER_ERROR = 500;
    const STATUS_CODE_SUCCESS = 200;
    /**
     * @param \Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createErrorResponse(\Exception $exception) {
        return response()->json(['error' => $exception->getMessage(), 'code' => $exception->getcode()],
            self::STATUS_CODE_SERVER_ERROR);
    }

    /**
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createSuccessResponse($data) {
        return response()->json($data, self::STATUS_CODE_SUCCESS);
    }
}

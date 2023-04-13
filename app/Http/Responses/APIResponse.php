<?php

namespace App\Http\Responses;


trait APIResponse {

    /**
     * Create object for success response
     *
     * @param  boolean|integer $status
     * @param  string  $message
     * @param  object|null  $body
     * @return \Illuminate\Http\JsonResponse
     *
     */
    protected function successResponse($status, $message = '', $body = null)
    {
        $response = new \stdClass;
        $response->status = $status;
        $response->message = $message;
        $response->body = $body;

        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Create object for versioning response
     *
     * @param  object|null  $body
     * @return \Illuminate\Http\JsonResponse
     *
     */
    protected function versioningResponse($body = null)
    {
        return response()->json($body, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Create object for fail response
     *
     * @param  boolean|integer $statusCode
     * @param  string  $message
     * @param  object|null  $body
     * @return \Illuminate\Http\JsonResponse
     *
     */
    protected function errorResponse($statusCode = 500, $message = '', $body = null)
    {
        $response = new \stdClass;

        $response->status = false;
        $response->message = $message;
        $response->body = $body;

        if (is_bool($statusCode))
        {
            $statusCode = 500;
        }

        return response()->json($response, $statusCode, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}

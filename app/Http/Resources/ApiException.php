<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ApiException extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => 'error',
            'data' => "{$this->getMessage()} Please contact our agents! Log: {$this->errorCode}"
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->getCode() ?: 404);
    }
}

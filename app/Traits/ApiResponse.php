<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponse{
    private function successResponse($data, $code){
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code){
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200){
        return $this->successResponse(['data' => $collection], $code);
    }

    protected function showOne(Model $model, $code = 200){
        return $this->successResponse(['data' => $model], $code);
    }

    protected function showMessage($message, $code = 200){
        return $this->successResponse(['data' => $message], $code);
    }

}
<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\UserResource;
use App\Http\Resources\v2\UserResource as V2UserResource;
use App\Models\User;
use Illuminate\Http\Request;

abstract class Controller
{
    protected function success($data = [], string $message = 'Operation successful', int $status = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }
    protected function responsePagination($paginator, $data = [], string $message = 'Operation successful', int $status = 200)
    {
        // Check if the first parameter is a paginator
        if ($paginator instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $pagination = [
                'current_page' => $paginator->currentPage(),
                'total_pages' => $paginator->lastPage(),
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'links' => [
                    'first' => $paginator->url(1),
                    'last' => $paginator->url($paginator->lastPage()),
                    'prev' => $paginator->previousPageUrl(),
                    'next' => $paginator->nextPageUrl(),
                ]
            ];
        } else {
            $pagination = null; 
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'pagination' => $pagination, 
        ], $status);
    }
    protected function error(string $message = 'An error occurred', int $status = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $status);
    }
    public function uploadImage($image,$folderPath){
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $uploadImage = $image->storeAs($folderPath,$filename,'public');
        return $uploadImage;
    }
    public function deleteImage($path){
        @unlink(storage_path('app/public/' . $path));
    }
}

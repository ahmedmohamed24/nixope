<?php

namespace App\traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

trait ApiResponse
{
    /**
     * get json response formatted.
     *
     * @param mixed $data
     * @param mixed $errors
     */
    public function response(int $statusCode, $data = [], $errors = []): JsonResponse
    {
        if ($data instanceof AnonymousResourceCollection) {
            // load pagination info when the data is paginated
            $meta = [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ];
        }

        return \response()->json([
            'data' => $data,
            'errors' => $errors,
            'meta' => $meta ?? [],
        ], $statusCode);
    }
}

<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait TablePagination
{
    /**
     * @param  LengthAwarePaginator  $data
     * @return array
     */
    public function paginate(LengthAwarePaginator $data): array
    {
        return [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'next_page_url' => $data->nextPageUrl(),
            'prev_page_url' => $data->previousPageUrl(),
            'path' => $data->path(),
        ];
    }
}

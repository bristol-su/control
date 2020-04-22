<?php

namespace BristolSU\ControlDB\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function paginate($items)
    {
        $perPage = request()->input('per_page', 10);
        $page = request()->input('page', 1);
        
        $slicedItems = collect($items)->forPage($page, $perPage)->values();
        
        return $this->paginationResponse($slicedItems, count($items));
    }

    public function paginationResponse($items, $count)
    {
        $perPage = request()->input('per_page', 10);
        $page = request()->input('page', 1);

        return (new LengthAwarePaginator(
            $items,
            $count,
            $perPage,
            $page,
            ['path' => url(request()->path())]
        ))->appends('per_page', $perPage);
    }
}

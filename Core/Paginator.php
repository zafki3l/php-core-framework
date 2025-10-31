<?php

namespace Core;

class Paginator
{
    const DEFAULT_RESULT_PER_PAGE = 8;

    public static function paginate(int $total_results, int $result_per_page, int $page) : array
    {
        $total_pages = ceil($total_results / $result_per_page);

        $page = max(1, min($page, $total_pages));

        $start_from = ($page - 1) * $result_per_page;

        return [
            'total_pages' => $total_pages,
            'page' => $page,
            'start_from' => $start_from
        ];
    }
}
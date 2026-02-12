<?php

function render_pagination(int $currentPage, int $totalPages, string $search, string $sort, string $dir): void
{
    if ($totalPages <= 1) {
        return;
    }

    $baseQuery = '&search=' . urlencode($search) . '&sort=' . urlencode($sort) . '&dir=' . urlencode($dir);
    $pageUrl = function (int $page) use ($baseQuery): string {
        return '?page=' . $page . $baseQuery;
    };

    echo '<ul class="pager">';

    $renderPage = function (int $page, bool $active = false) use ($pageUrl): void {
        if ($active) {
            echo '<li class="active"><a href="#">' . $page . '</a></li>';
            return;
        }
        echo '<li><a href="' . $pageUrl($page) . '">' . $page . '</a></li>';
    };

    $renderEllipsis = function (): void {
        echo '<li class="disabled"><a href="#">...</a></li>';
    };

    if ($totalPages <= 5) {
        if ($currentPage > 1) {
            echo '<li><a href="' . $pageUrl($currentPage - 1) . '">&laquo;</a></li>';
        }
        for ($p = 1; $p <= $totalPages; $p++) {
            $renderPage($p, $p === $currentPage);
        }
        if ($currentPage < $totalPages) {
            echo '<li><a href="' . $pageUrl($currentPage + 1) . '">&raquo;</a></li>';
        }
        echo '</ul>';
        return;
    }

    if ($currentPage > 1) {
        echo '<li><a href="' . $pageUrl($currentPage - 1) . '">&laquo;</a></li>';
    }

    // Always show first page
    $renderPage(1, $currentPage === 1);

    // Calculate window around current page
    if ($currentPage <= 2) {
        $start = 2;
        $end = 3;
    } elseif ($currentPage >= $totalPages - 1) {
        $start = $totalPages - 2;
        $end = $totalPages - 1;
    } else {
        $start = $currentPage - 1;
        $end = $currentPage + 1;
    }

    if ($start > 2) {
        $renderEllipsis();
    }

    for ($p = $start; $p <= $end; $p++) {
        $renderPage($p, $p === $currentPage);
    }

    if ($end < $totalPages - 1) {
        $renderEllipsis();
    }

    // Always show last page
    $renderPage($totalPages, $currentPage === $totalPages);

    if ($currentPage < $totalPages) {
        echo '<li><a href="' . $pageUrl($currentPage + 1) . '">&raquo;</a></li>';
    }

    echo '</ul>';
}

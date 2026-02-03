<?php

function render_pagination(int $currentPage, int $totalPages, string $search, string $sort, string $dir): void
{
    if ($totalPages <= 1) {
        return;
    }

    echo '<ul class="pager">';

    if ($currentPage === $totalPages || ($currentPage > 1 && $currentPage < $totalPages)) {
        echo '<li><a href="?page=1&search=' . urlencode($search) . '&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">First</a></li>';
    }

    if ($currentPage > 1) {
        echo '<li><a href="?page=' . ($currentPage - 1) . '&search=' . urlencode($search) . '&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">&laquo;</a></li>';
    }

    $window = 2;
    $start = max(1, $currentPage - $window);
    $end = min($totalPages, $currentPage + $window);

    if ($start > 1) {
        echo '<li class="disabled"><a href="#">...</a></li>';
    }

    for ($p = $start; $p <= $end; $p++) {
        if ($p === $currentPage) {
            echo '<li class="active"><a href="#">' . $p . '</a></li>';
        } else {
            echo '<li><a href="?page=' . $p . '&search=' . urlencode($search) . '&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">' . $p . '</a></li>';
        }
    }

    if ($end < $totalPages) {
        echo '<li class="disabled"><a href="#">...</a></li>';
    }

    if ($currentPage < $totalPages) {
        echo '<li><a href="?page=' . ($currentPage + 1) . '&search=' . urlencode($search) . '&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">&raquo;</a></li>';
    }

    if ($currentPage === 1 || ($currentPage > 1 && $currentPage < $totalPages)) {
        echo '<li><a href="?page=' . $totalPages . '&search=' . urlencode($search) . '&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">Last</a></li>';
    }

    echo '</ul>';
}

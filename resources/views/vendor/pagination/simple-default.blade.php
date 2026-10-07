<style>
    .table-container {
    overflow-x: auto;
    margin-top: 20px;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Arial', sans-serif;
}

.admin-table th, .admin-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

.admin-table th {
    background-color: #f5f5f5;
    font-weight: 600;
}

.table-row:hover {
    background-color: #f9f9f9;
}

.status-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-block;
}

.status-badge.eligible {
    background-color: #d4edda;
    color: #155724;
}

.status-badge.not-eligible {
    background-color: #f8d7da;
    color: #721c24;
}

.action-btn {
    padding: 6px 10px;
    border: none;
    border-radius: 6px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    font-size: 0.85rem;
}

.action-btn:hover {
    background-color: #0056b3;
}

/* Pagination Styling */
.pagination-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    flex-wrap: wrap;
}

.pagination-info {
    font-size: 0.9rem;
    color: #555;
}

.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    gap: 5px;
    margin: 10px 0;
}

.pagination li {
    border: 1px solid #ddd;
    padding: 6px 12px;
    border-radius: 4px;
}

.pagination li a {
    text-decoration: none;
    color: #333;
}

.pagination li.active span {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.pagination li.disabled span {
    color: #aaa;
    cursor: default;
}

</style>


@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Page Links --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif

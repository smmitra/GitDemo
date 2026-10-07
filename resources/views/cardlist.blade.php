@extends('layouts.master')

<link rel="stylesheet" href="{{ asset('public/admin/assets/css/cardlist-styles.css') }}">
    

@section('main_content')
    <div class="admin-container">
        <!-- Page Header -->
        <div class="admin-header">
            <div class="header-content">
                <div class="header-left">
                    <h2 class="page-title">
                        <span class="title-icon">🎫</span>
                        Scratchcards Management
                    </h2>
                    <p class="page-subtitle">Manage and monitor all scratch cards in the system</p>
                </div>
                <div class="header-stats">
                    <div class="stat-cardd">
                        <div class="stat-value">{{ $totalCards }}</div>
                        <div class="stat-label">Total Cards</div>
                    </div>
                    <div class="stat-cardd">
                        <div class="stat-value">{{ $totalPrizeEligible }}</div>
                        <div class="stat-label">Prize Eligible</div>
                    </div>

                    <div class="stat-cardd">
                        <div class="stat-value">{{ $totalNotEligible  }}</div>
                        <div class="stat-label">Prize NotEligible</div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <div class="filters-card">
                <div class="filters-header">
                    <h3 class="filters-title">
                        <span class="filter-icon">🔍</span>
                        Filters & Search
                    </h3>
                </div>
                <form method="GET" class="filters-form">
                {{-- Prize Filter (if you want back, just uncomment)
                <div class="filter-group">
                    <label class="filter-label">Prize Status</label>
                    <select name="prize" class="filter-select">
                        <option value="">All Cards</option>
                        <option value="yes" {{ request('prize') == 'yes' ? 'selected' : '' }}>Has Prize</option>
                        <option value="no" {{ request('prize') == 'no' ? 'selected' : '' }}>No Prize</option>
                    </select>
                </div>
                --}}

                <div class="filter-group">
                    <label class="filter-label">Card Price</label>
                    <input type="number" name="price" value="{{ request('price') }}" 
                        placeholder="Exact price" class="filter-input" style="height: 42px;">
                </div>

                <div class="filter-group">
                    <label class="filter-label">Price Range</label>
                    <div class="range-inputs">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" 
                            placeholder="Min" class="filter-input" style="width:100px; height: 42px;">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" 
                            placeholder="Max" class="filter-input" style="width:100px; height: 42px;">
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-search">
                        🔍 Search
                    </button>
                    <button type="button" class="btn-reset" onclick="window.location.href='{{ url()->current() }}'">
                        Clear Filters
                    </button>
                </div>
            </form>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="table-section">
            <div class="table-card">
                <div class="table-header">
                    <h3 class="table-title">Scratchcards List</h3>
                    <div class="table-actions">
                        {{-- <button class="btn-export">
                            <span class="btn-icon">📊</span>
                            Export
                        </button> --}}
                        {{-- <a href="{{ route('scratchcards_export_all') }}" 
                        class="btn-export">
                            <span class="btn-icon">📊</span>
                            Export
                        </a> --}}
                        <button class="btn-refresh" onclick="window.location.reload()">
                            <span class="btn-icon">🔄</span>
                            Refresh
                        </button>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th class="th-number">#</th>
                                <th class="th-card">Card Details</th>
                                <th class="th-price">Price</th>
                                <th class="th-batch">Batch</th>
                                <th class="th-status">Prize Status</th>
                                <th class="th-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cards as $card)
                                <tr class="table-row">
                                    <td class="td-number">
                                        <span class="row-number">{{ $loop->iteration + ($cards->currentPage() - 1) * $cards->perPage() }}</span>
                                    </td>
                                    <td class="td-card">
                                        <div class="card-info">
                                            <div class="card-number">{{ $card->card_number }}</div>
                                            <div class="card-meta">Card ID: #{{ $card->id }}</div>
                                        </div>
                                    </td>
                                    <td class="td-price">
                                        <div class="price-display">
                                            <span class="currency">$</span>
                                            <span class="amount">{{ $card->card_price }}</span>
                                        </div>
                                    </td>
                                    <td class="td-batch">
                                        <div class="batch-info">
                                            <span class="batch-label">Batch</span>
                                            <span class="batch-number">{{ $card->batch_no }}</span>
                                        </div>
                                    </td>
                                    <td class="td-status">
                                    @if ($card->is_prize_eligible)
                                        <span class="status-badge status-eligible">
                                            <span class="badge-icon">✓</span>
                                            Prize Eligible
                                        </span>
                                    @else
                                        <span class="status-badge status-not-eligible">
                                            <span class="badge-icon">✗</span>
                                            No Prize
                                        </span>
                                    @endif
                                </td>

                                <td class="td-actions">
                                    @if (! $card->is_prize_eligible) 
                                        <form method="POST" action="{{ route('scratchcards_togglePrize', $card->id) }}" class="action-form">
                                            @csrf
                                            <button class="action-btn btn-toggle" title="Toggle Prize Status">
                                                <span class="btn-icon">🔄</span>
                                                <span class="btn-text">Toggle Prize</span>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
              <!-- Pagination -->
                <div class="pagination-section">
                    <div class="pagination-info">
                        Showing {{ $cards->firstItem() ?? 0 }} to {{ $cards->lastItem() ?? 0 }} of {{ $cards->total() }} results
                    </div>
                    <div class="pagination-wrapper">
                        {!! $cards->links('vendor.pagination.simple-default') !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

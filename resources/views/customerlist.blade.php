@extends('layouts.master')

<link rel="stylesheet" href="{{ asset('public/admin/assets/css/cardlist-styles.css') }}">

<style>
    .filter-section {
        margin-bottom: 20px;
        display: flex;
        justify-content: flex-start;
    }

    .filter-form {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .filter-label {
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    .filter-select {
        padding: 8px 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        background: #f9f9f9;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .filter-select:hover {
        border-color: #007bff;
        background: #fff;
    }

    .filter-select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
    }
</style>

    
@section('main_content')
    <div class="admin-container">
        <!-- Page Header -->
        
        <!-- Filters Section -->
        <div class="filter-section" style="margin-bottom: 20px;">
            <form method="GET" action="{{ route('customer_list') }}" class="filter-form">
                <label for="winner_filter">Filter by Winner Status:</label>
                <select name="winner" id="winner_filter" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="1" {{ request('winner') == '1' ? 'selected' : '' }}>Winner</option>
                    <option value="0" {{ request('winner') == '0' ? 'selected' : '' }}>Not Winner</option>
                </select>
            </form>
        </div>

        <!-- Data Table Section -->
        <div class="table-section">
            <div class="table-card">
                <div class="table-header">
                    <h3 class="table-title">Customer List</h3>
                    <div class="table-actions">
                        <button class="btn-refresh" onclick="window.location.href='{{ route('customer_list') }}'">
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
                                <th class="th-number">Customer Number</th>
                                <th class="th-card">Card No</th>
                                <th class="th-price">Price</th>
                                <th class="th-status">Winner Status</th>
                                <th class="th-status">Whatsapp Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allcustomer as $card)
                                <tr class="table-row">
                                    <td class="td-number">
                                        <span class="row-number">{{ $loop->iteration }}</span>
                                    </td>
                                    
                                    <td class="td-card">
                                        <div class="card-info">
                                            <div class="card-number">{{ $card->phone }}</div>
                                        </div>
                                    </td>

                                    <td class="td-card">
                                        <div class="card-info">
                                            <div class="card-number">{{ $card->card_number }}</div>
                                        </div>
                                    </td>

                                    <td class="td-price">
                                        <div class="price-display">
                                            <div class="card-number">{{ $card->prize_amount }}</div>
                                        </div>
                                    </td>

                                    <td class="td-batch">
                                        <div class="batch-info">
                                            {{ $card->is_winner == 1 ? 'YES' : 'NO' }}
                                        </div>
                                    </td>

                                    <td class="td-batch">
                                        <div class="batch-info">
                                            {{ $card->admin_whatsapp_sent == 1 ? 'YES' : 'NO' }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center;">No customers found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                {{-- 
                <div class="pagination-section">
                    <div class="pagination-info">
                        Showing {{ $allcustomer->firstItem() ?? 0 }} to {{ $allcustomer->lastItem() ?? 0 }} of {{ $allcustomer->total() }} results
                    </div>
                    <div class="pagination-wrapper">
                        {!! $allcustomer->links('vendor.pagination.simple-default') !!}
                    </div>
                </div> 
                --}}
            </div>
        </div>
    </div>
@endsection

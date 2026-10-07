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
                        Batch List Management
                    </h2>
                    <p class="page-subtitle">Manage and monitor all scratch cards in the system</p>
                </div>

            </div>
        </div>



        <!-- Data Table Section -->
        <div class="table-section">
            <div class="table-card">
                <div class="table-header">
                    <h3 class="table-title">Batch List</h3>
                    <div class="table-actions">

                    </div>
                </div>

                <div class="table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Batch No</th>
                                <th>Batch Price</th>
                                <th>Export PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($batches as $batch)
                                <tr class="table-row">
                                    <td class="td-number">
                                        <span class="card-number">{{ $batch->batch_no }}</span>
                                    </td>

                                    <td class="td-card">
                                        <div class="card-info">
                                            <div class="card-number">{{ $batch->card_price }}</div>
                                        </div>
                                    </td>

                                    <td>
                                        <a href="{{ route('scratchcards_pdf', ['batch' => $batch->batch_no]) }}"
                                            class="btn btn-primary btn-sm">
                                            📄 Export
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-section">
                    <div class="pagination-info">
                        Showing {{ $batches->firstItem() ?? 0 }} to {{ $batches->lastItem() ?? 0 }} of
                        {{ $batches->total() }} results
                    </div>
                    <div class="pagination-wrapper">
                        {!! $batches->links('vendor.pagination.simple-default') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

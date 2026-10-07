@extends('layouts.master')

<link rel="stylesheet" href="{{ asset('public/admin/assets/css/generator-styles.css') }}">

@section('main_content')
    <!-- Top Header -->
    <header class="top-header">
        <div class="header-left">
            <h1>Disbursed Card</h1>
            {{-- <p>Create and customize your own scratch cards</p> --}}
        </div>
        {{-- <div class="header-right">
            <div class="balance-widget">
                <div class="balance-info">
                    <span class="balance-label">Balance</span>
                    <span class="balance-amount">$2,450.00</span>
                </div>
                <button class="add-funds-btn">Add Funds</button>
            </div>
        </div> --}}
    </header>

    <!-- Generator Controls -->
    <section class="generator-controls">
        <div class="control-panel">
            <div class="control-group">
                <h3>Disbursed Card Configuration</h3>
                <form action="{{ route('disbursedscratchcards_store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="form-field">
                            <label for="disbursed_card_quantity">Number of Card Disbursed</label>
                            <input type="number" name="disbursed_card_quantity" id="disbursed_card_quantity"
                                placeholder="e.g. 100" required>
                        </div>

                        <div class="form-field">
                            <label for="card_price">Disbursed Card Price</label>
                            <input type="number" name="disbursed_card_price" id="disbursed_card_price"
                                placeholder="e.g. 100" required>
                        </div>

                        <div class="form-field">
                            <label for="disbursed_card_date">Disbursed Card Date</label>
                            <input type="date" name="disbursed_card_date" id="disbursed_card_date" required>
                        </div>

                    </div>
                    <br>
                    <button type="submit" id="submitBtn" class="add-prize-btn">Submit</button>
                </form>


            </div>
        </div>
    </section>


    <hr>
    <h3>Scratch Card Summary</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse: collapse; text-align:center;">
        <thead style="background:#f5f5f5;">
            <tr>
                <th>Card Price</th>
                <th>Total Disbursed</th>
                <th>Remaining</th>
                <th>Last Disbursed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach (DB::table('scratchcard_batches')->select('price', DB::raw('SUM(quantity) as total_disbursed'), DB::raw('MAX(disbursed_at) as last_disbursed'))->groupBy('price')->get() as $row)
                @php
                    $remaining = DB::table('scratchcards')
                        ->where('card_price', $row->price)
                        ->where('status', 'unused')
                        ->count();
                @endphp

                <tr>
                    <td>₹{{ $row->price }}</td>
                    <td>{{ $row->total_disbursed }}</td>
                    <td>{{ $remaining }}</td>
                    <td>{{ $row->last_disbursed }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <!-- jQuery must come before Toastr -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr CSS + JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        });

    </script>
@endsection

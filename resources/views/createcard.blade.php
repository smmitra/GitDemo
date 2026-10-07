@extends('layouts.master')

<link rel="stylesheet" href="{{ asset('public/admin/assets/css/generator-styles.css') }}">

@section('main_content')
    <!-- Top Header -->
    <header class="top-header">
        <div class="header-left">
            <h1>Scratch Card Generator</h1>
            <p>Create and customize your own scratch cards</p>
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
                <h3>Card Configuration</h3>
                <form id="generateForm" action="{{ route('scratchcards_store') }}" method="POST">
                    @csrf   
                    <div class="form-grid">
                        <div class="form-field">
                            <label for="quantity">Number of Cards</label>
                            <input type="number" name="quantity" id="quantity" placeholder="e.g. 100" required>
                        </div>

                        <div class="form-field">
                            <label for="card_price">Card Price</label>
                            <input type="number" name="card_price" id="card_price" placeholder="e.g. 100" required>
                        </div>
                    </div>
                    <br>
                    <button type="submit" id="generateBtn" class="add-prize-btn">+ Generate</button>
                </form>

                <!-- Loader -->
                <div id="loader" style="display:none; margin-top:10px; color:blue;">
                    <strong>⏳ Cards are being generated. Please wait...</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery must come before Toastr -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr CSS + JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
    $(document).ready(function () {
        $('#generateForm').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let $btn = $('#generateBtn'); 

            $btn.prop('disabled', true).text('Generating...'); // disable button
            $('#loader').show();

            $.ajax({
                url: "{{ route('scratchcards_store') }}",
                type: "POST",
                data: $form.serialize(),
                success: function(res) {
                    $('#loader').hide();
                    $btn.prop('disabled', false).text('+ Generate'); // re-enable button

                    if (res.success) {
                        toastr.success(res.message); // show toastr
                        $form[0].reset(); // reset form
                    } else {
                        toastr.error("Something went wrong, please try again.");
                    }
                },
                error: function(err) {
                    $('#loader').hide();
                    $btn.prop('disabled', false).text('+ Generate');
                    toastr.error('Error generating scratchcards.');
                }
            });
        });
    });
    </script>
@endsection

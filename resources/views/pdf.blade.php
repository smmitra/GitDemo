<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Scratchcards - Batch {{ $batch }}</title>
    {{-- <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
            color: #5e3370;
        }



        .card-grid {
            width: 100%;
            text-align: center;
            /* helps alignment */
        }

        .scratchcard {
            width: 300px;
            height: 200px;
            margin: 5px;
            display: inline-block;
            /* ✅ side by side */
            vertical-align: top;
            position: relative;
            background: url('{{ public_path('admin/assets/scrimg/69dd.png') }}') no-repeat center center;
            background-size: cover;
        }

        .scratchcard .card-number {
            position: absolute;
            bottom: 17px;
            left: 40%;
            /* center horizontally */
            transform: translateX(-32%);
            font-size: 12px;
            font-weight: bold;
            background: transparent;
        }
    </style> --}}

     <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
            color: #5e3370;
        }
        .card-grid {
            width: 100%;
            text-align: center;
        }
        .scratchcard {
            width: 300px;
            height: 200px;
            margin: 5px;
            display: inline-block;
            vertical-align: top;
            position: relative;
            background: url('{{ public_path('admin/assets/scrimg/69dd.png') }}') no-repeat center center;
            background-size: cover;
        }
        .qr-code {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 3px;
            border-radius: 4px;
        }
    </style>

</head>

<body>

    <h2>Scratchcards - Batch {{ $batch }}</h2>


    {{-- <div class="card-grid">
        @foreach ($cards as $card)
            <div class="scratchcard">
                <div class="card-number">
                    {{ $card->card_number }}
                </div>
            </div>
        @endforeach
    </div> --}}

    


    <div class="card-grid">
        @foreach ($cards as $card)
            <div class="scratchcard">
                <div class="qr-code">
                    @php
    $secret = base64_encode(json_encode(['id' => $card->id, 'token' => md5($card->id . 'renuka_secret_key')]));
    $url = "https://renukarice.in/renukarice/form.php?code=" . urlencode($secret);
    $qrCode = base64_encode(QrCode::format('svg')->size(80)->generate($url));
@endphp
                    <img src="data:image/svg+xml;base64, {!! $qrCode !!}" alt="QR Code">
                </div>
            </div>
        @endforeach
    </div>



</body>

</html>

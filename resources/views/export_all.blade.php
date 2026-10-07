<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>All Scratchcards</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            color: #333; 
        }
        h1, h2 { 
            margin: 0; 
            padding: 5px 0; 
        }
        h2 { 
            background: #f2f2f2; 
            padding: 8px 10px; 
            margin-top: 20px;
            border-radius: 4px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 6px 8px; 
            text-align: center; 
        }
        th { 
            background: #ddd; 
        }
        .price { 
            font-weight: bold; 
            color: #2c3e50; 
        }
        .eligible { 
            color: green; 
            font-weight: bold; 
        }
        .no-prize { 
            color: red; 
            font-weight: bold; 
        }
    </style>
</head>
<body>

    <h1>Renuka Rice Scratchcards Report</h1>
    <p>Generated on: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>

    @foreach ($allBatches as $batchNo => $cards)
        <h2>Batch: {{ $batchNo }}</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Card Number</th>
                    <th>Price ($)</th>
                    <th>Prize Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cards as $index => $card)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $card->card_number }}</td>
                        <td class="price">{{ $card->card_price }}</td>
                        <td class="{{ $card->is_prize_eligible ? 'eligible' : 'no-prize' }}">
                            {{ $card->is_prize_eligible ? 'Eligible' : 'No Prize' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>
</html>

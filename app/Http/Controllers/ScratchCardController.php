<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scratchcard;
use App\Models\CardSubmission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ScratchCardController extends Controller
{
    //

    public function index(){

        return view('createcard');
    }

    public function disbursedindex(){
        return view('disbursedcardview');
    }


    public function show($encryptedCode)
    {
        try {
            // Decrypt the code from the URL
            $cardNumber = Crypt::decryptString($encryptedCode);

            // Now that you have the original card number,
            // you can find the card details from the database if needed.
            
            // Return a view and pass the card number to it
            return view('show_card_form', ['cardNumber' => $cardNumber]);

        } catch (DecryptException $e) {
            // This will catch errors if the code is invalid or has been tampered with.
            // You can return an error view or a 404 page.
            abort(404, 'Invalid or expired link.');
        }
    }



    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'quantity' => 'required|integer|min:1',
    //         'card_price' => 'required|integer',
    //         'month' => 'required|date_format:Y-m'
    //     ]);

    //     $batchNo = now()->format('Ym') . '-B' . rand(100,999);

    //     for ($i=1; $i <= $request->quantity; $i++) {
    //         Scratchcard::create([
    //             'batch_no' => $batchNo,
    //             'card_number' => strtoupper(uniqid('SCR-')),
    //             'card_price' => $request->card_price,
    //             'month' => $request->month.'-01'
    //         ]);
    //     }

    //     return redirect()->route('scratchcards_index')->with('success', 'Scratchcards generated!');
    // }

 public function store(Request $request)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'card_price' => 'required|integer|min:1',
    ]);

    $quantity = $request->quantity;
    $cardPrice = $request->card_price;
    $batchNo = now()->format('Ym') . '-B' . rand(100,999);
    $month = now()->startOfMonth();

    $chunkSize = 1000;
    $cards = [];

    for ($i = 1; $i <= $quantity; $i++) {
        $cardNumber = 'RNK-' . $batchNo . '-' . str_pad($i, 6, '0', STR_PAD_LEFT);

        $cards[] = [
            'batch_no' => $batchNo,
            'card_number' => $cardNumber,
            'card_price' => $cardPrice,
            'month' => $month,
            'is_prize_eligible' => false,
            'created_at' => now(),
            'updated_at' => now(),
            'status' =>'unused',
        ];

        if (count($cards) == $chunkSize) {
            DB::table('scratchcards')->insert($cards);
            $cards = [];
        }
    }

    if (count($cards) > 0) {
        DB::table('scratchcards')->insert($cards);
    }

    return response()->json([
        'success' => true,
        'message' => "Successfully generated $quantity scratchcards in batch $batchNo"
    ]);
}


    public function list(Request $request)
{
    $query = Scratchcard::query();

    // Prize filter
    if ($request->has('prize') && $request->prize !== '') {
        $query->where('is_prize_eligible', $request->prize == 'yes' ? 1 : 0);
    }

    // Price filter (exact match or range)
    if ($request->filled('price')) {
        $query->where('card_price', $request->price);
    }

    if ($request->filled('min_price')) {
        $query->where('card_price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('card_price', '<=', $request->max_price);
    }

    $cards = $query->orderBy('id','asc')->paginate(100);
    $totalPrizeEligible = Scratchcard::where('is_prize_eligible', 1)->count();
    $totalCards = Scratchcard::count();
    $totalNotEligible = Scratchcard::where('is_prize_eligible', 0)->count();

    return view('cardlist', compact('cards','totalPrizeEligible','totalCards','totalNotEligible'));
}




public function pricehaslist(Request $request){
    $query = Scratchcard::query();
    // Price filter (exact match or range)
    if ($request->filled('price')) {
        $query->where('card_price', $request->price);
    }

    if ($request->filled('min_price')) {
        $query->where('card_price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('card_price', '<=', $request->max_price);
    }

    $cards = $query->where('is_prize_eligible', 1)->orderBy('id', 'asc')->paginate(100);
    return view('pricehascardlist', compact('cards'));
}







     public function togglePrize($id)
    {
        $card = Scratchcard::findOrFail($id);
        $card->is_prize_eligible = !$card->is_prize_eligible;
        $card->save();

        return back()->with('success', 'Prize eligibility updated!');
    }

    // public function exportPdf($batch)
    // {
    //     $cards = Scratchcard::where('batch_no', $batch)->get();

    //     $pdf = Pdf::loadView('pdf', compact('cards','batch'));
    //     return $pdf->download("scratchcards-{$batch}.pdf");
    // }

//     public function exportPdf($batch)
// {
//     $cards = Scratchcard::where('batch_no', $batch)->get();

//     if ($cards->isEmpty()) {
//         return back()->with('error', 'No cards found for this batch.');
//     }

//     $pdf = Pdf::loadView('pdf', compact('cards','batch'));
//     return $pdf->download("scratchcards-{$batch}.pdf");
// }


public function exportPdf($batch)
{
    $cards = Scratchcard::where('batch_no', $batch)->get();

    if ($cards->isEmpty()) {
        return back()->with('error', 'No cards found for this batch.');
    }

    $chunks = $cards->chunk(200); // split into 1000 per PDF
    $zipFile = storage_path("app/public/scratchcards-{$batch}.zip");

    $zip = new \ZipArchive;
    if ($zip->open($zipFile, \ZipArchive::CREATE) === TRUE) {
        $i = 1;
        foreach ($chunks as $chunk) {
            $pdf = PDF::loadView('pdf', ['cards' => $chunk, 'batch' => $batch]);
            $pdfPath = storage_path("app/public/scratchcards-{$batch}-part{$i}.pdf");
            $pdf->save($pdfPath);
            $zip->addFile($pdfPath, "scratchcards-{$batch}-part{$i}.pdf");
            $i++;
        }
        $zip->close();
    }

    return response()->download($zipFile)->deleteFileAfterSend(true);
}








public function batchList()
{
    // Fetch distinct batch numbers
    $batches = Scratchcard::select('batch_no','card_price')
        ->distinct()
        ->orderBy('batch_no', 'asc')
        ->paginate(50000);

    // dd($batches);    

    return view('batchlist', compact('batches'));
}


// public function exportAll()
// {
//     // Fetch all scratchcards, grouped by batch_no
//     $allBatches = Scratchcard::orderBy('batch_no')
//         ->get()
//         ->groupBy('batch_no');

//     // Load view
//     $pdf = Pdf::loadView('export_all', compact('allBatches'));

//     // Download PDF
//     return $pdf->download('all_scratchcards.pdf');
// }

public function exportAll()
{
    // Dispatch the PDF generation job
    \App\Jobs\GenerateScratchcardPdfZip::dispatch();

    return back()->with('message', 'PDF generation started. You will be notified when ready.');
}




public function storedisbursed(Request $request)
{
    $request->validate([
        'disbursed_card_quantity' => 'required|integer|min:1',
        'disbursed_card_price'    => 'required|integer|min:1',
        'disbursed_card_date'     => 'required|date',
    ]);

    $quantity = $request->disbursed_card_quantity;
    $price    = $request->disbursed_card_price;
    $date     = $request->disbursed_card_date;

    // Check available cards of that price
    $availableCards = DB::table('scratchcards')
        ->where('card_price', $price)
        ->where('status', 'unused')
        ->count();

    // dd($availableCards);    

    if ($availableCards == 0) {
        return redirect()->back()->with('error', "No card available of price ₹$price");
    }

    if ($quantity > $availableCards) {
        return redirect()->back()->with('error', "Disbursed quantity ($quantity) is higher than available quantity ($availableCards)");
    }

    // Generate unique batch number
    $batchNo = 'BATCH-' . date('YmdHis');

    // Store batch summary
    DB::table('scratchcard_batches')->insert([
        'batch_no'        => $batchNo,
        'price'           => $price,
        'quantity'        => $quantity,
        'remaining_count' => $availableCards - $quantity,
        'disbursed_at'    => $date,
        'created_at'      => now(),
        'updated_at'      => now(),
    ]);

    // Update only requested number of cards
    $updated = DB::table('scratchcards')
        ->where('card_price', $price)
        ->where('status', 'unused')
        ->limit($quantity)
        ->update([
            'status'       => 'used',
            'disbursed_at' => $date,
            'updated_at'   => now(),
        ]);

    return redirect()->back()->with('success', "Disbursed $updated cards of price ₹$price successfully!");
}



public function customerlist(Request $request){

    $query = CardSubmission::query();

    if ($request->has('winner') && $request->winner !== '') {
        $query->where('is_winner', $request->winner);
    }

    $allcustomer = $query->get(); // or paginate()

    return view('customerlist',compact('allcustomer'));
}










}

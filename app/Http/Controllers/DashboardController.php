<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scratchcard;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //

    public function index(){

    $totalPrizeEligible = Scratchcard::where('is_prize_eligible', 1)->count();
    $totalCards = Scratchcard::count();
    $totalNotEligible = Scratchcard::where('is_prize_eligible', 0)->count();

    $batches = Scratchcard::select('batch_no', 'card_price', DB::raw('COUNT(*) as total_cards'))
    ->groupBy('batch_no', 'card_price')
    ->orderBy('batch_no', 'asc')
    ->get();   


        return view('dashboard',compact('totalPrizeEligible','totalCards','totalNotEligible','batches'));
    }
}

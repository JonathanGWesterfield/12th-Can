<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        #$orderTransactions = Transaction
        #return Transaction::all();
        $activeItems = Item::all()->where('removed','0');
        return view('pages.dashboard')->with('activeItems', $activeItems);
    }
    
    public static function test()
    {
        return;
    }
}

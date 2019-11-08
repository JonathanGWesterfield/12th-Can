<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Transaction;

class HistoryController extends Controller
{
    public function index()
    {
        #$orderTransactions = Transaction
        #return Transaction::all();
        $activeItems = Item::all()->where('removed','false');
        return view('pages.history')->with('activeItems', $activeItems);
    }

    public static function test()
    {
        return "This has been a test";
    }
}

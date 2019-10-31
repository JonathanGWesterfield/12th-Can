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
        $activeTransactions = Transaction::all();
        return view('pages.dashboard')->with('activeItems', $activeItems)->with('activeTransactions', $activeTransactions);
    }

    public static function test()
    {
        return;
    }
}

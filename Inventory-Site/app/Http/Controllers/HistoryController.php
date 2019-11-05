<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Transaction;

class HistoryController extends Controller
{
    public function index()
    {
        $activeItems = Item::all()->where('removed','false');
        $activeTransactions = Transaction::all();
        return view('pages.history')->with('activeItems', $activeItems)->with('activeTransactions', $activeTransactions);
    }
}

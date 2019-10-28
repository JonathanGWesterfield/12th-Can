<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function newItems()
    {
        return view('pages.new_items');
    }
    public function modifyItems()
    {
        return view('pages.modifyItems');
    }
}

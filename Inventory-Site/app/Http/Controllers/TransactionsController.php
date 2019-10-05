<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage. Is used to input a new transaction into the
     * database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required',
            'user_id' => 'required',
            'quantity_change' => 'required',
        ]);

        try
        {
            // Transaction date is created by the database current timestamp
            $transaction = new Transaction();
            $transaction->item_id = $request->input('item_id');
            $transaction->member_id = $request->input('user_id');
            $transaction->quantChange = $request->input('quantity_change');

            if($request->input('comment') != null)
                $transaction->comment = $request->input('comment');

            $transaction->save();
        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'transaction failed',
                'error' => $e->getMessage()
            ], 500);
        }

//        return redirect('/new_transactions')->with('success', 'transaction Added');
        return response([
            'status' => 'transaction succeeded',
            'transaction_item' => $transaction->item_id,
            'transaction_user' => $transaction->member_id,
            'transaction_change' =>  $transaction->quantChange], 200)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

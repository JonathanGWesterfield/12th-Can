<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use App\Item;
use Illuminate\Support\Facades\DB;

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
     * @param  \Illuminate\Http\Request  $request A json array of transactions to submit
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: WRITE THE TESTS FOR THIS CHANGE

        try
        {
            $transactions = json_decode($request->getContent(), true);

            // Go through every item submitted and create it
            foreach($transactions as $elem)
            {
                $item = Item::find($elem['item_id']);
                $user = User::find($elem['user_id']);

                $transaction = new Transaction();
                $transaction->item()->associate($item);
                $transaction->user()->associate($user);
                $transaction->item_quantity_change = $elem['quantity_change'];
                $transaction->transaction_date = date("Y-m-d H:i:s"); // current time
                $transaction->comment = "";

                // The user commenting on a transaction is optional
                if(array_key_exists('comment', $elem))
                    $transaction->comment = $elem['comment'];

                $transaction->save();
            }

            return response([
                'status' => 'transaction(s) stored',
                'transactions_count' => count($transactions)], 200)
                ->header('Content-Type', 'text/plain');
        }
        catch (Exception $e)
        {
            dd($e->getMessage());
            // Attempt to catch a bad database store
            return response([
                'status' => 'item modification failed',
                'error' => $e->getMessage()
            ], 422);
        }
    }


// Old transaction function. Needs to have more than one transaction at a time.
//$this->validate($request, [
//'item_id' => 'required',
//'user_id' => 'required',
//'quantity_change' => 'required',
//]);
//
//try
//{
//    // Transaction date is created by the database current timestamp
//$transaction = new Transaction();
//$transaction->item_id = $request->input('item_id');
//$transaction->member_id = $request->input('user_id');
//$transaction->item_quantity_change = $request->input('quantity_change');
//
//if($request->input('comment') != null)
//$transaction->comment = $request->input('comment');
//
//$transaction->save();
//}
//catch (Exception $e)
//        {
//            // Attempt to catch a bad database store
//            return response([
//                'status' => 'transaction failed',
//                'error' => $e->getMessage()
//            ], 500);
//        }
//
////        return redirect('/new_transactions')->with('success', 'transaction Added');
//        return response([
//            'status' => 'transaction succeeded',
//            'transaction_item' => $transaction->item_id,
//            'transaction_user' => $transaction->member_id,
//            'transaction_change' =>  $transaction->item_quantity_change], 200)
//            ->header('Content-Type', 'text/plain');

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

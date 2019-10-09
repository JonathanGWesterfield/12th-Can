<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use function MongoDB\BSON\toJSON;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        console.log("Here");
        return Item::NotRemoved()->all();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'capacity' => 'required',
            'threshold' => 'required',
            'isFood' => 'required',
            'refrigerated' => 'required'
        ]);

        try{
            $item = new Item;
            $item->name = $request->input('name');
            $item->quantity = 0;
            $item->capacity = $request->input('capacity');
            $item->low_threshold = $request->input('threshold');
            $item->is_food = $request->input('isFood');
            $item->refrigerated = $request->input('refrigerated');
            $item->created_at = date("Y-m-d H:i:s"); // updated_at uses the database timestamp
            $item->removed = false;
            $item->save();
        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'item creation failed',
                'error' => $e->getMessage()
            ], 500);
        }

//        return redirect('/new_items')->with('success', 'Item Added');
        return response([
            'status' => 'item created',
            'item_name' => $item->name,
            'item_quantity' => $item->quantity,
            'item_capacity' =>  $item->capacity,
            'item_threshold' => $item->low_threshold,
            'item_is_food' => $item->is_food,
            'item_refrigerated' => $item->created_at,
            'item_removed' => $item->removed], 200)
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
        // TODO: TEST THIS TO MAKE SURE IT WORKS
        $item = Item::find($id);
        return view('pages.modifyItems')->with('item', $item);
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
     * @param  int  $id The ID of the item we want to modify. Is the Primary key in the Item table.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'capacity' => 'required',
            'threshold' => 'required',
            'isFood' => 'required',
            'refrigerated' => 'required',
            'removed' => 'required'
        ]);

        try{
            $item = Item::find($id);
            $item->name = $request->input('name');
            $item->capacity = $request->input('capacity');
            $item->low_threshold = $request->input('threshold');
            $item->is_food = $request->input('isFood');
            $item->refrigerated = $request->input('refrigerated');
            $item->removed = $request->input('removed');
            $item->save();
        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'item modification failed',
                'error' => $e->getMessage()
            ], 500);
        }

        // If the item is removed, have the response reflect that.
        if($item->removed == 'true')
            return response([
                'status' => 'item removed',
                'item_id' => $item->id,
                'item_name' => $item->name,
                'item_removed' => $item->removed], 200)
                ->header('Content-Type', 'text/plain');

        return response([
            'status' => 'item modified',
            'item_id' => $item->id,
            'item_name' => $item->name,
            'item_quantity' => $item->quantity,
            'item_capacity' =>  $item->capacity,
            'item_threshold' => $item->low_threshold,
            'item_is_food' => $item->is_food,
            'item_refrigerated' => $item->refrigerated], 200)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified item from storage. We don't really delete the item. We just
     * marked the 'removed' column for that item as true so we can filter it out. We want the
     * customer to be able to re-add old items that were once deleted if they need to.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO: TEST THIS TO MAKE SURE IT WORKS
        $item = Item::find($id);
        $item->removed = true;
        $item->save();

        return response([
            'status' => 'item removed',
            'item_name' => $item->name,
            'item_quantity' => $item->quantity,
            'item_capacity' =>  $item->capacity,
            'item_threshold' => $item->low_threshold,
            'item_is_food' => $item->is_food,
            'item_refrigerated' => $item->created_at,
            'item_removed' => $item->removed], 200)
            ->header('Content-Type', 'text/plain');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member_Position;
use PhpParser\Node\Expr\PostDec;

class MemberPositionsController extends Controller
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

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'position' => 'required|string',
            'privilege' => 'required|integer',
            'description' => 'required|string',
            'email' => 'required|string'
        ]);
        // TODO: WRITE TESTS FOR THIS
        try
        {
            $position = new Member_Position();
            $position->position = $request->input('position');
            $position->privilege = $request->input('privilege');
            $position->description = $request->input('description');
            $position->email = $request->input('email');
            $position->created_at = date("Y-m-d H:i:s");

            $position->save();
        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'Member Position creation failed',
                'error' => $e->getMessage()
            ], 500);
        }

        return response([
            'status' => 'position creation succeeded',
            'position_item' => $position->position,
            'position_user' => $position->privilege,
            'position_change' =>  $position->email], 200)
            ->header('Content-Type', 'text/plain');
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        //
//    }

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function edit($id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id ID of the member position we need to modify
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'position' => 'required|string',
            'privilege' => 'required|integer',
            'description' => 'required|string',
            'email' => 'required|string'
        ]);
        // TODO: WRITE TESTS FOR THIS
        try
        {
            $position = Member_Position::find($id);
            $position->position = $request->input('position');
            $position->privilege = $request->input('privilege');
            $position->description = $request->input('description');
            $position->email = $request->input('email');
            $position->created_at = date("Y-m-d H:i:s");

            $position->save();
        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'Member Position modification failed',
                'error' => $e->getMessage()
            ], 500);
        }

        return response([
            'status' => 'position modification succeeded',
            'position_item' => $position->position,
            'position_user' => $position->privilege,
            'position_change' =>  $position->email], 200)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO: WRITE A TEST FOR THIS
        $position = Member_Position::find($id);
        $position->delete();
    }
}

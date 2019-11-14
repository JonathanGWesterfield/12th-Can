<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Member_Position;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
class UsersController extends Controller
{
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        //
//    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }

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
     * @param  int  $id ID of the user specified
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'phone' => 'required',
            'current_member' => 'required',
            'position_id' => 'required'
        ]);
        // TODO: WRITE TESTS FOR THIS
        try
        {
            $position = Member_Position::find($request->input('position_id'));
            $user = User::find($id);
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->current_member = $request->input('current_member');
            $user->position()->associate($position);

//            $user->position_id = $request->input('position_id');

            $user->save();
        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'User Info Modification Failed',
                'error' => $e->getMessage()
            ], 500);
        }

        return response([
            'status' => 'User Info Modification Succeeded',
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'user_current_member' =>  $user->current_member,
            'user_position_id' => strval($user->position_id)], 200)
            ->header('Content-Type', 'text/plain');
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy($id)
//    {
//        //
//    }
}

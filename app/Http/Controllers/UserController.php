<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return all tasks of the User.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function tasks($id){
        if( User::find($id)->task()->count() > 0){
            $tasks = User::find($id)->task;

            return response()->json([ 'tasks' =>  $tasks ]);
        }

        else
            return response()->json([ 'tasks' => null ]);
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}

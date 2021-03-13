<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json( Task::all() );
    }

    /**
     * Create a new Task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_task = $request->input('task');

        $task = new Task();

        $task->name = $request_task['name'];
        $task->details = $request_task['details'];
        $task->status = $request_task['status'];
        $task->id_user = $request_task['id_user'];

        try{
            $task->save();
            return response()->json([ 'success'=> true ]);
        }
        catch(Exception $e){
            return response()
                    ->json([
                        'success'=> false,
                        'error'=> $e->getMessage()
                    ]);
        }
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
        try{
            Task::find($id)->delete();
            return response()->json(['success'=> true]);
        }

        catch(QueryExcepion $e){
            return response()->json([
                'success'=> false,
                'error'=> $e.getMessage()
            ]);
        }
    }
}

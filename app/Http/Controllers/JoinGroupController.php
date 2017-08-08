<?php

namespace App\Http\Controllers;

use App\JoinGroup;
use Illuminate\Http\Request;

use App\Http\Requests;

class JoinGroupController extends Controller
{
    public function index()
    {
        //
    }

    public function checkJoinGroup(Request $request){
        $join = JoinGroup::where('user_id',$request->user_id)
            ->where('group_id',$request->group_id)
            ->first();
        if($join === NULL){
            return response()->json(['error' => 'Error msg'], 209);
        }
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $join = new JoinGroup;
        $join->user_id = $request->user_id;
        $join->group_id = $request->group_id;
        $join->save();
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}

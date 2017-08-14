<?php

namespace App\Http\Controllers;

use App\JoinGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function findMemberGroup(Request $request){
        $memberList = DB::table('join_groups')
            ->join('users', 'join_groups.user_id', '=', 'users.id')
            ->select('join_groups.*', DB::raw('CONCAT(users.prefix,users.fname_th," ", users.lname_th) AS fullName'),'users.stu_id')
            ->where('join_groups.group_id',$request->group_id)
            ->orderBy('stu_id','ASC')
            ->get();
        return response()->json($memberList);
    }

    public function exitGroup(Request $request){
        $join = JoinGroup::where('user_id',$request->user_id)
            ->where('group_id',$request->group_id)->first();
        $join->delete();
    }

    public function stdMyGroup(){
        return view('pages/stdMyGroup');
    }

    public function findMyJoinGroup(Request $request){
        $myGroup = DB::table('join_groups')
            ->join('groups', 'join_groups.group_id', '=', 'groups.id')
            ->join('users', 'groups.user_id', '=', 'users.id')
            ->select('join_groups.*','groups.group_name', DB::raw('CONCAT("อ.",users.fname_th," ", users.lname_th) AS creater'))
            ->where('join_groups.user_id',$request->user_id)
            ->orderBy('fname_th','ASC')
            ->orderBy('group_name','ASC')
            ->get();
        return response()->json($myGroup);
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

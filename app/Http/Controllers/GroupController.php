<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function findAllGroup()
    {
        $groupList = DB::table('groups')
            ->join('users', 'groups.user_id', '=', 'users.id')
            ->select('groups.*', DB::raw('CONCAT("อ.",users.fname_th," ", users.lname_th) AS creater'))
            ->orderBy('fname_th','ASC')
            ->orderBy('group_name','ASC')
            ->get();
//        $findAllSection = Section::all()->orderBy('section_name');
        return response()->json($groupList);
    }
    public function findMyGroup(Request $request)
    {
        $groupList = DB::table('groups')
            ->join('users', 'groups.user_id', '=', 'users.id')
            ->select('groups.*', 'users.prefix','users.fname_th','users.lname_th')
            ->where('groups.user_id',$request->id)
            ->orderBy('group_name','ASC')
            ->get();
        return response()->json($groupList);
    }
    public function ManageGroup(Request $request)
    {
        $findGroup = Group::where('group_name', $request->group_name)
            ->where('user_id', $request->user_id)
            ->first();
        if ($findGroup === NULL) {
            $group = new Group;
            $group->user_id = $request->user_id;
            $group->group_name = $request->group_name;
            $group->group_pass = $request->pass_name;
            $group->save();
        } else {
            return response()->json(['error' => 'Error msg'], 209);
        }
    }
    public function group()
    {
        $group = Group::all();
        $data = array(
            'group'=> $group

        );
        return view('pages.group',$data);
    }

    public function stdGroup(){
        return view('pages.stdGroup');
    }

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Request $request)
    {
        $findSectionName = Group::where('group_name', $request->group_name)
            ->where('user_id', $request->user_id)
            ->first();
        if ($findSectionName === NULL) {
            $group = Group::find($request->id);
            $group->group_name = $request->group_name;
            $group->group_pass = $request->pass_name;
            $group->save();
        } else{
            if ($findSectionName->id == $request->id){
                $group = Group::find($request->id);
                $group->group_name = $request->group_name;
                $group->group_pass = $request->pass_name;
                $group->save();
            } else {
                return response()->json(['error' => 'Error msg'], 209);
            }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $section = Group::find($request->id);
        $section->delete();
        //
    }
}

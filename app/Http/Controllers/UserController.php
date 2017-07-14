<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use Psy\Util\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $findUser = Users::where('personal_id', $request->personalId)->first();
        if ($findUser === NULL) {
            $users = new Users;
            $users->personal_id = $request->personalId;
            $users->prefix = $request->prename;
            $users->fname_en = $request->cn;
            $users->fname_th = $request->firstNameThai;
            $users->lname_en = $request->sn;
            $users->lname_th = $request->lastNameThai;
            $users->stu_id = $request->studentId;
            $users->faculty = $request->faculty;
            $users->department = $request->program;
            $users->email = $request->mail;
            if($request->gidNumber == "4500"){
                $users->user_type = 's';
            }elseif ($request->gidNumber == "2800"){
                $users->user_type = 't';
            }else{
                $users->user_type = 'o';
            }
            $users->save();
            return response()->json($users);
        }else{
            $users = Users::find($findUser->id);
            $users->personal_id = $request->personalId;
            $users->prefix = $request->prename;
            $users->fname_en = $request->cn;
            $users->fname_th = $request->firstNameThai;
            $users->lname_en = $request->sn;
            $users->lname_th = $request->lastNameThai;
            $users->stu_id = $request->studentId;
            $users->faculty = $request->faculty;
            $users->department = $request->program;
            $users->email = $request->mail;
            if($request->gidNumber == "4500"){
                $users->user_type = 's';
            }elseif ($request->gidNumber == "2800"){
                $users->user_type = 't';
            }else{
                $users->user_type = 'o';
            } $users->save();
            return response()->json($users);
//            return response()->json("Happy");
        }
    }

    public function findByPersonalID(Request $request){
        $findUser = Users::where('personal_id', $request->personalId)->first();
        return $findUser;
    }

    public function findCreaterByPersonalID($PID){
        $findUser = Users::where('personal_id', $PID)->first();
        return $findUser;
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Examing;
use Illuminate\Http\Request;

use App\Http\Requests;

class ExamingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages/openExam');
    }

    public function findExamingByNameAndGroup(Request $request)
    {
        $examing = Examing::where('examing_name',$request->examing_name)
            ->where('group_id',$request->group_id)
            ->first();
        if ($examing === NULL) {
//             return true;
        }else{
            return response()->json(['error' => 'Error msg'], 209);
        }
    }

    public function createExaming(Request $request)
    {
        $examing = new Examing;
        $examing->user_id = $request->user_id;
        $examing->group_id = $request->group_id;
        $examing->examing_mode = $request->examing_mode;
        $examing->amount = $request->amount;
        $examing->start_date_time = $request->start_date_time;
        $examing->end_date_time = $request->end_date_time;
        $examing->examing_pass = $request->examing_pass;
        $examing->examing_name = $request->examing_name;
        $examing->ip_group = $request->ip_group;
        $examing->save();

        $examing = Examing::where('user_id',$request->user_id)
            ->where('examing_name',$request->examing_name)->first();

        return response()->json($examing);
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
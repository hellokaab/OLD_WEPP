<?php

namespace App\Http\Controllers;

use App\Examing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class ExamingController extends Controller
{
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
        $examing->hide_examing = $request->hide_examing;
        $examing->hide_history = $request->hide_history;
        $examing->save();

        $examing = Examing::where('user_id',$request->user_id)
            ->where('examing_name',$request->examing_name)->first();

        return response()->json($examing);
    }

    public  function  updateExaming(Request $request){
        $examing = Examing::find($request->id);
        $examing->group_id = $request->group_id;
        $examing->examing_mode = $request->examing_mode;
        $examing->amount = $request->amount;
        $examing->start_date_time = $request->start_date_time;
        $examing->end_date_time = $request->end_date_time;
        $examing->examing_pass = $request->examing_pass;
        $examing->examing_name = $request->examing_name;
        $examing->ip_group = $request->ip_group;
        $examing->hide_examing = $request->hide_examing;
        $examing->hide_history = $request->hide_history;
        $examing->save();
    }

    public function examingHistory(){
        return view('pages/openExamHistory');
    }

    public function findExamingByUserID(Request $request){
        $examing = Examing::where('user_id',$request->user_id)
            ->orderBy('start_date_time','ASC')
            ->orderBy('end_date_time','ASC')
            ->orderBy('examing_name','ASC')
            ->get();
        return response()->json($examing);
    }

    public function findExamingByID(Request $request){
        $examing = Examing::find($request->id);
        return response()->json($examing);
    }

    public function findSTDExamingItsComing(Request $request){
        $examing = Examing::where('group_id',$request->group_id)
            ->where('end_date_time','>',DB::raw('NOW()'))
            ->where('hide_examing','1')
            ->orderBy('start_date_time','ASC')
            ->orderBy('end_date_time','ASC')
            ->orderBy('examing_name','ASC')
            ->get();
        return response()->json($examing);
    }

    public function findExamingItsComing(Request $request){
        $examing = Examing::where('group_id',$request->group_id)
            ->where('end_date_time','>',DB::raw('NOW()'))
            ->orderBy('start_date_time','ASC')
            ->orderBy('end_date_time','ASC')
            ->orderBy('examing_name','ASC')
            ->get();
        return response()->json($examing);
    }

    public function findExamingItsEnding(Request $request){
        $examing = Examing::where('group_id',$request->group_id)
            ->where('end_date_time','<',DB::raw('NOW()'))
            ->orderBy('start_date_time','ASC')
            ->orderBy('end_date_time','ASC')
            ->orderBy('examing_name','ASC')
            ->get();
        return response()->json($examing);
    }

    public function changeHiddenExaming(Request $request){
        $examing = Examing::find($request->id);
        $examing->hide_examing = $request->hide_examing;
        $examing->save();
    }

    public function changeHistoryExaming(Request $request){
        $examing = Examing::find($request->id);
        $examing->hide_history = $request->hide_history;
        $examing->save();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = array(
            'examingID' => $id
        );
        return view('pages/editExaming',$data);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        $examing = Examing::find($request->id);
        $examing->delete();
    }
}

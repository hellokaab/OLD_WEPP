<?php

namespace App\Http\Controllers;

use App\ExamRandom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class ExamRandomController extends Controller
{

    public function index()
    {
        //
    }

    public function findExamRandomByUID(Request $request)
    {
        $examRandom = ExamRandom::where('user_id',$request->user_id)->get();
        return response()->json($examRandom);
    }

    public function create()
    {
        //
    }

    public function findExamRandomInViewExam(Request $request){
        $examExaming = DB::table('exam_randoms')
            ->join('exams', 'exam_randoms.exam_id', '=', 'exams.id')
            ->select('exam_randoms.*', 'exams.*')
            ->where('examing_id',$request->examing_id)
            ->where('exam_randoms.user_id',$request->user_id)
            ->get();
        return response()->json($examExaming);
    }

    public function addRandomExam($examing_id,$user_id,$exam_id)
    {
        $examRandom = new ExamRandom;
        $examRandom->examing_id = $examing_id;
        $examRandom->user_id = $user_id;
        $examRandom->exam_id = $exam_id;
        $examRandom->save();
    }


    public function store(Request $request)
    {

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

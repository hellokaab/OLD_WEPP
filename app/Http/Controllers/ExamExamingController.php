<?php

namespace App\Http\Controllers;

use App\ExamExaming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class ExamExamingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function findExamExamingByExamingID(Request $request){
        $examExaming = ExamExaming::where('examing_id',$request->examing_id)->get();
        return response()->json($examExaming);
    }

    public function findExamExamingInViewExam(Request $request){
        $examExaming = DB::table('exam_examings')
            ->join('exams', 'exam_examings.exam_id', '=', 'exams.id')
            ->select('exam_examings.*', 'exams.*')
            ->where('examing_id',$request->examing_id)
            ->get();
        return response()->json($examExaming);
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
        $examExaming = new ExamExaming;
        $examExaming->exam_id = $request->exam_id;
        $examExaming->examing_id = $request->examing_id;
        $examExaming->save();
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
    public function update(Request $request)
    {
        $examExaming = ExamExaming::where('exam_id',$request->exam_id)
            ->where('examing_id',$request->examing_id)->first();
        if($examExaming === NULL){
            $newEEM = new ExamExaming;
            $newEEM->exam_id = $request->exam_id;
            $newEEM->examing_id = $request->examing_id;
            $newEEM->save();
        }
    }


    public function destroy(Request $request)
    {
        $examExaming = DB::table('exam_examings')
            ->where('exam_id',$request->exam_id)
            ->where('examing_id',$request->examing_id)
            ->first();
        $delEEM = ExamExaming::find($examExaming->id);
        $delEEM->delete();
    }
}

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
        $examRandom = ExamRandom::where('user_id',$request->user_id)
            ->where('examing_id',$request->examing_id)
            ->get();
        return response()->json($examRandom);
    }

    public function create()
    {
        //
    }

    public function findExamRandomInViewExam(Request $request){
        $examExaming = DB::select(' SELECT ex.exam_name,a.* 
                                    FROM exams AS ex INNER JOIN(
                                        SELECT er.*,re.current_status 
                                        FROM exam_randoms AS er LEFT JOIN(
                                            SELECT * 
                                            FROM res_exams 
                                            WHERE res_exams.user_id = ? ) AS re
                                        ON er.examing_id = re.examing_id
                                        WHERE er.user_id = ?
                                        AND er.examing_id = ? ) AS a
                                        ON ex.id = a.exam_id', [$request->user_id,$request->user_id,$request->examing_id]);
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

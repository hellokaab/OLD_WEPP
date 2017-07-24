<?php

namespace App\Http\Controllers;

use App\ShareExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class ShareExamController extends Controller
{
    public function index()
    {
        //
    }

    public function findSharedUserNotMe(Request $request){
        $shared = DB::table('share_exams')
            ->where('exam_id',$request->exam_id)
            ->where('user_id', '!=',$request->my_id)
            ->get();
        return response()->json($shared);
    }

    public function deleteUserShared(Request $request){
        $selectShared = DB::table('share_exams')
            ->where('exam_id',$request->exam_id)
            ->where('user_id',$request->user_id)
            ->first();
        $delShared = ShareExam::find($selectShared->id);
        $delShared->delete();
    }

    public function updateSharedExam(Request $request){
        $shared = ShareExam::where('exam_id',$request->exam_id)
            ->where('user_id',$request->user_id)
            ->first();
        if ($shared === NULL) {
           $newShared = new ShareExam;
           $newShared->exam_id = $request->exam_id;
           $newShared->user_id = $request->user_id;
           $newShared->save();
        }
    }

    public function findSectionSharedToMe(Request $request){
        $section = DB::table('share_exams')
            ->join('exams', 'share_exams.exam_id', '=', 'exams.id')
            ->join('sections', 'exams.section_id', '=', 'sections.id')
            ->join('users', 'sections.user_id', '=', 'users.id')
            ->select('sections.*', DB::raw('CONCAT("อ.",users.fname_th," ", users.lname_th) AS creater'))
            ->where('share_exams.user_id',$request->my_id)
            ->groupBy('sections.id')
            ->orderBy('creater', 'asc')
            ->orderBy('sections.section_name', 'asc')
            ->get();
        return response()->json($section);
    }

    public function findSectionSharedNotMe(Request $request){
        $section = DB::table('share_exams')
            ->join('exams', 'share_exams.exam_id', '=', 'exams.id')
            ->join('sections', 'exams.section_id', '=', 'sections.id')
            ->join('users', 'sections.user_id', '=', 'users.id')
            ->select('sections.*', DB::raw('CONCAT("อ.",users.fname_th," ", users.lname_th) AS creater'))
            ->where('share_exams.user_id',$request->my_id)
            ->where('sections.user_id','!=',$request->my_id)
            ->groupBy('sections.id')
            ->orderBy('creater', 'asc')
            ->orderBy('sections.section_name', 'asc')
            ->get();
        return response()->json($section);
    }

    public function findExamSharedToMe(Request $request){
        $exam = DB::table('share_exams')
            ->join('exams', 'share_exams.exam_id', '=', 'exams.id')
            ->select('exams.*')
            ->where('share_exams.user_id',$request->my_id)
            ->orderBy('exams.exam_name', 'asc')
            ->get();
        return response()->json($exam);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $share = new ShareExam;
        $share->exam_id = $request->exam_id;
        $share->user_id = $request->user_id;
        $share->save();
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

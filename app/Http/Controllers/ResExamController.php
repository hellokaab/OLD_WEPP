<?php

namespace App\Http\Controllers;

use App\ExamExaming;
use App\ReadyQueueEx;
use App\ResExam;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class ResExamController extends Controller
{
    public function checkQueueEx(Request $request){
        $first = ReadyQueueEx::orderBy('id')->first();
        if($first->path_exam_id == $request->pathExamID){
            return response()->json($first->file_type, 200);
        } else {
            return response()->json(['error' => 'Error msg'], 209);
        }
    }

    public function store($EMID,$EID,$UID,Request $request)
    {
        $user = Users::find($UID);
        $userFolder = $user->stu_id."_".$user->fname_en."_".$user->lname_en;
        $examingFolder = "Examing_".$EMID;
        $examFolder = "Exam_".$EID;
        $path = "../upload/resexam/";

//        สร้างโฟลเดอร์ของการสอบ
        $this->makeFolder($path,$examingFolder);
//        สร้างโฟลเดอร์ของข้อสอบในการสอบ
        $this->makeFolder($path.$examingFolder."/",$examFolder);
//        สร้างโฟลเดอร์ของนักเรียนที่ส่งข้อสอบ
        $this->makeFolder($path.$examingFolder."/".$examFolder."/",$userFolder);

        $folderName = date('Ymd-His')."_".rand(1, 9999);
        $folder = $path.$examingFolder."/".$examFolder."/".$userFolder."/".$folderName;
        mkdir($folder, 0777, true);
        $files = $request->file('file_ans');
        foreach ($files as &$file) {
            $file->move($folder,$file->getClientOriginalName());
        }
        return response()->json($folder);
    }

    public function deleteFirstQueue(){
        $first = ReadyQueueEx::orderBy('id')->first();
        $first->delete();
    }

    public function examInScoreboard(Request $request){
        $examInScoreboard = DB::table('exam_examings')
            ->join('exams', 'exam_examings.exam_id', '=', 'exams.id')
            ->select('exam_examings.*', 'exams.exam_name','exams.full_score')
            ->where('exam_examings.examing_id',$request->examing_id)
            ->orderBy('exam_examings.exam_id','ASC')
            ->get();
        return response()->json($examInScoreboard);
    }

    public function dataInScoreboard(Request $request){
        $listStd = DB::table('users')
            ->join('join_groups', 'users.id', '=', 'join_groups.user_id')
            ->select('users.id','users.stu_id', DB::raw('CONCAT(users.prefix,users.fname_th," ",users.lname_th) AS full_name'))
            ->where('join_groups.group_id',$request->group_id)
            ->orderBy('users.stu_id','ASC')
            ->get();

        $examExamig = ExamExaming::where('examing_id',$request->id)
            ->orderBy('exam_id','ASC')
            ->get();
//        return response()->json($listStd);
        $score = array();
        $i = 0;
        foreach ($listStd as $stu) {
            $score[$i]["stu_id"] = $stu->stu_id;
            $score[$i]["full_name"] = $stu->full_name;
            $score[$i]["res_status"] = array();
            foreach ($examExamig as $eem) {
                $status = DB::select('SELECT res_exams.* 
                                      FROM exam_examings,res_exams 
                                      WHERE exam_examings.examing_id = res_exams.examing_id
                                      AND exam_examings.exam_id = res_exams.exam_id
                                      AND exam_examings.examing_id = ?
                                      AND exam_examings.exam_id = ?
                                      AND res_exams.user_id = ?',[$request->id,$eem->exam_id,$stu->id]);
                array_push($score[$i]["res_status"],$status);
            }
            $i++;
        }
        return response()->json($score);
    }

    function makeFolder($path,$folder) {
        $dirList = scandir($path);
        if (!in_array((string) $folder, (array) $dirList)) {
            mkdir($path.$folder, 0777, true);
        }
    }

    public function editScore(Request $request){
        $resexam = ResExam::find($request->resexam_id);
        $resexam->score = $request->score;
        $resexam->save();
    }
}

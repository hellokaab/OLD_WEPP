<?php

namespace App\Http\Controllers;

use App\ReadyQueueEx;
use App\Users;
use Illuminate\Http\Request;

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

    function makeFolder($path,$folder) {
        $dirList = scandir($path);
        if (!in_array((string) $folder, (array) $dirList)) {
            mkdir($path.$folder, 0777, true);
        }
    }
}

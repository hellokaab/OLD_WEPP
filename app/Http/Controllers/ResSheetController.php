<?php

namespace App\Http\Controllers;

use App\ReadyQueueSh;
use App\Users;
use Illuminate\Http\Request;

use App\Http\Requests;

class ResSheetController extends Controller
{
    public function checkQueueSh(Request $request){
        $first = ReadyQueueSh::orderBy('id')->first();
        if($first->path_sheet_id == $request->pathSheetID){
            return response()->json($first->file_type, 200);
        } else {
            return response()->json(['error' => 'Error msg'], 209);
        }
    }

    public function uploadSheetFile($STID,$SID,$UID,Request $request)
    {
        $user = Users::find($UID);
        $userFolder = $user->stu_id."_".$user->fname_en."_".$user->lname_en;
        $sheetingFolder = "Sheeting_".$STID;
        $sheetFolder = "Sheet_".$SID;
        $path = "../upload/resworksheet/";

//        สร้างโฟลเดอร์เก็บข้อสอบที่ส่ง
        $this->makeFolder("../upload/","resworksheet");
//        สร้างโฟลเดอร์ของการสอบ
        $this->makeFolder($path,$sheetingFolder);
//        สร้างโฟลเดอร์ของข้อสอบในการสอบ
        $this->makeFolder($path.$sheetingFolder."/",$sheetFolder);
//        สร้างโฟลเดอร์ของนักเรียนที่ส่งข้อสอบ
        $this->makeFolder($path.$sheetingFolder."/".$sheetFolder."/",$userFolder);

        $folderName = date('Ymd-His')."_".rand(1, 9999);
        $folder = $path.$sheetingFolder."/".$sheetFolder."/".$userFolder."/".$folderName;
        mkdir($folder, 0777, true);
        $files = $request->file('file_ans');
        foreach ($files as &$file) {
            $file->move($folder,$file->getClientOriginalName());
        }
        return response()->json($folder);
    }

    public function deleteFirstQueueSh(){
        $first = ReadyQueueSh::orderBy('id')->first();
        $first->delete();
    }

    function makeFolder($path,$folder) {
        $dirList = scandir($path);
        if (!in_array((string) $folder, (array) $dirList)) {
            mkdir($path.$folder, 0777, true);
        }
    }
}

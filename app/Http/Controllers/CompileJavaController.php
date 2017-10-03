<?php

namespace App\Http\Controllers;

use App\PathExam;
use App\ReadyQueueEx;
use App\ResExam;
use App\Users;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class CompileJavaController extends Controller
{
    //
    public function sendExamJava(Request $request){
        $default_package = TRUE;
        $folder_ans = "";
        $resExamID = "";
//        ถ้าพิมพ์โค้ดส่ง
        if($request->mode === "key") {
            $code = $request->code;
//            ตรวจสอบว่าเป็น default package หรือเปล่า
            $default_package = $this->is_default_package($code);
            if ($default_package) {
//                สร้างโฟลเดอร์เก็บไฟล์ที่ส่ง
                $user = Users::find($request->UID);
                $userFolder = $user->stu_id . "_" . $user->fname_en . "_" . $user->lname_en;
                $examingFolder = "Examing_" . $request->EMID;
                $examFolder = "Exam_" . $request->EID;
                $path = "../upload/resexam/";
//                สร้างโฟลเดอร์ของการสอบ
                $this->makeFolder($path, $examingFolder);
//                สร้างโฟลเดอร์ของข้อสอบในการสอบ
                $this->makeFolder($path . $examingFolder . "/", $examFolder);
//                สร้างโฟลเดอร์ของนักเรียนที่ส่งข้อสอบ
                $this->makeFolder($path . $examingFolder . "/" . $examFolder . "/", $userFolder);
                $folderName = date('Ymd-His') . "_" . rand(1, 9999);
                $folder_ans = $path . $examingFolder . "/" . $examFolder . "/" . $userFolder . "/" . $folderName;
                mkdir($folder_ans, 0777, true);

//                สร้างไฟล์เก็บโค้ดที่ส่งมา
                $code = stripslashes($code);

//                ตั้งชื่อไฟล์ให้เหมือนชื่อคลาส
                $file_name = $this->get_class_name($code);
                $file_ans = "$file_name.java";

//                เขียนไฟล์
                $handle = fopen("$folder_ans/$file_ans", 'w') or die('Cannot open file:  ' . $file_ans);
                fwrite($handle, $code);
                fclose($handle);
            }

        } else {
//            แต่ถ้าส่งไฟล์โค้ดมา
            $folder_ans = $request->path;
            $files = scandir($folder_ans);
            foreach ($files as $f) {
//                 ลูปเช็ค package ทุกไฟล์ที่มีนามสกุล .java
                if (strpos($f, '.java') && $default_package) {
                    $handle = fopen("$folder_ans/$f", "r");
                    $code_in_file = fread($handle, filesize("$folder_ans/$f"));
                    fclose($handle);
                    $default_package = $this->is_default_package($code_in_file);
                }
            }

            if(!$default_package){
//                 ลบไฟล์ที่ถูกส่งมา
                $files = scandir($folder_ans);
                foreach ($files as $f) {
                    @unlink("$folder_ans/$f");
                }
                rmdir($folder_ans);
            }
        }

        if ($default_package) {
//            บันทึกลงฐานข้อมูล ตาราง res_exams
            $resExam = ResExam::where('examing_id',$request->EMID)
                ->where('exam_id',$request->EID)
                ->where('user_id',$request->UID)
                ->first();
            if($resExam === NULL){
                $resExam = new ResExam;
                $resExam->examing_id = $request->EMID;
                $resExam->exam_id = $request->EID;
                $resExam->user_id = $request->UID;
                $resExam->save();
                $insertedId = $resExam->id;
                $resExamID = $insertedId;
            } else {
                $resExamID = $resExam->id;
            }

//            บันทึกลงฐานข้อมูล ตาราง path_exams
            $pathExam = new PathExam;
//            $pathExam->resexam_id = $resExam->id;
            $pathExam->resexam_id = $resExamID;
            $pathExam->path = $folder_ans;
            $pathExam->send_date_time = date("Y-m-d H:i:s");
            $pathExam->ip = $_SERVER['REMOTE_ADDR'];
            $pathExam->save();
            $insertedId = $pathExam->id;
            $pathExamID = $insertedId;

//            บันทึกลงฐานข้อมูล ready_queue_exes
            $readyQueue = new ReadyQueueEx;
            $readyQueue->path_exam_id = $pathExamID;
            $readyQueue->file_type = "java";
            $readyQueue->save();
            $insertedId = $readyQueue->id;
            return response()->json($insertedId);

        } else {
            return response()->json(['error' => 'Error msg'], 209);
        }
    }

    function is_default_package($code) {
        $class = $this->get_class_name($code);
        if ($class) {
            $pos_begin_class = strpos($code, $class);
            $code_before_class = substr($code, 0, $pos_begin_class);

            if (is_int(strpos($code_before_class, 'package '))) {
                return FALSE;
            }
        }
        return TRUE;
    }

    function get_class_name($code) {
        $tmp = explode('class', $code);
        $tmp2 = explode('{', $tmp[1]);
        $class = trim($tmp2[0]);
        return $class ? $class : FALSE;
    }

    function makeFolder($path,$folder) {
        $dirList = scandir($path);
        if (!in_array((string) $folder, (array) $dirList)) {
            mkdir($path.$folder, 0777, true);
        }
    }
}

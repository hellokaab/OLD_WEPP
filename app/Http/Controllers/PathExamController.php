<?php

namespace App\Http\Controllers;

use App\PathExam;
use Illuminate\Http\Request;

use App\Http\Requests;

class PathExamController extends Controller
{
    public function findPathExamByResExamID(Request $request){
        $pathExam = PathExam::where('resexam_id',$request->resexam_id)->get();
        return response()->json($pathExam);
    }

    public function getCode(Request $request){
        $folder_ans = $request->path;
        $code = array();
        //ค้นหาไฟล์ในโฟลเดอร์ข้อสอบที่ส่ง
        $files = scandir($folder_ans);
        foreach ($files as $f) {
            // ลูปหาไฟล์นามสกุล.java ที่ไม่ใช่ Main.java
            if (strpos($f, '.java') && $f != 'Main.java') {
                $handle = fopen("$folder_ans/$f", "r");
                $codeInFile = fread($handle, filesize("$folder_ans/$f"));
                array_push($code, $codeInFile);
                fclose($handle);
            }

            else if (strpos($f, '.c') && $f != 'ex.c' && $f != 'ex.cpp') {
                $handle = fopen("$folder_ans/$f", "r");
                $codeInFile = fread($handle, filesize("$folder_ans/$f"));
                array_push($code, $codeInFile);
                fclose($handle);
            }

//            else if (strpos($f, '.cpp') && $f != 'ex.cpp') {
//                $handle = fopen("$folder_ans/$f", "r");
//                $codeInFile = fread($handle, filesize("$folder_ans/$f"));
//                array_push($code, $codeInFile);
//                fclose($handle);
//            }
        }

        return response()->json($code);
    }

    public function readFileResRun(Request $request){
        $file_resrun = $request->path;
        $handle = fopen("$file_resrun", "r");
        $resrun = trim(fread($handle, filesize("$file_resrun")));
        fclose($handle);
        return response()->json($resrun);
    }
}

<?php

namespace App\Http\Controllers;

use App\Exam;
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
        $completeInsRes = false;
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

        try{
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
                    $resExam->current_status = "q";
                    $resExam->sum_accep = 0;
                    $resExam->sum_imp = 0;
                    $resExam->sum_wrong = 0;
                    $resExam->sum_comerror = 0;
                    $resExam->sum_overtime = 0;
                    $resExam->sum_overmem = 0;
                    $resExam->save();
                    $insertedId = $resExam->id;
                    $resExamID = $insertedId;
                } else {
                    $resExamID = $resExam->id;
                }
                $completeInsRes = true;

//            บันทึกลงฐานข้อมูล ตาราง path_exams
                $pathExam = new PathExam;
//            $pathExam->resexam_id = $resExam->id;
                $pathExam->resexam_id = $resExamID;
                $pathExam->path = $folder_ans;
                $pathExam->status = "q";
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
                return response()->json($pathExamID);

            } else {
                return response()->json(['error' => 'Error msg'], 209);
            }
        } catch( Exception $e ){
            if($completeInsRes){
                $delResExam = ResExam::find($resExamID);
                $delResExam->delete();
            }

//            ลบไฟล์ที่ส่งมา
            $files = scandir($folder_ans);
            foreach ($files as $f) {
                @unlink("$folder_ans/$f");
            }
            rmdir($folder_ans);

            return response()->json(['error' => 'Error msg'], 210);
        }
    }

    public function compileAndRunJava(Request $request){
        $status = "";
        $folder_ans = "";
        // คิวรี่ ที่อยู่ของไฟล์ที่ส่ง
        if($request->mode == "exam"){
            $pathExam = PathExam::find($request->pathExamID);
            $folder_ans = $pathExam->path;
        }


        // ตรวจหาเมธอด main() ในโฟลเดอร์ แล้วเก็บ ชื่อไฟล์ที่มีเมธอด main() ใน $file_main
        $files = scandir($folder_ans);
        $file_main = null;
        foreach ($files as $f) {
            if (strpos($f, '.java')) {
                // ถ้าในไฟล์นี้ มีเมธอด main()
                if ($this->is_main("$folder_ans/$f")) {
                    $file_main = $f;
                }
            }
        }

        // ถ้าเจอเมธอด main() ในโฟลเดอร์
        if ($file_main) {
            // อ่านโค้ดในไฟล์
            $myfile = fopen("$folder_ans/$file_main", 'r');
            $origin_code = fread($myfile, filesize("$folder_ans/$file_main"));
            fclose($myfile);

            // แก้ชื่อคลาสเป็น Main
            $class_name = $this->get_class_name($origin_code);
            $pos_begin_class_name = strpos($origin_code, $class_name);
            $new_class_code = substr_replace($origin_code, 'Main', $pos_begin_class_name, strlen($class_name));

            // เพิ่มโค้ดส่วนการเช็คลูป เช็คเมมโมรี่ เช็คเวลา
            $code_add_checker = $this->add_check_code($new_class_code);

            // เก็บไว้ในไฟล์ชื่อ Main.java
            $file = 'Main';
            $handle = fopen("$folder_ans/$file.java", 'w') or die('Cannot open file:  ' . $file);
            fwrite($handle, $code_add_checker);

            // คอมไพล์โค้ดที่ส่ง
            $this->compile_code($folder_ans, $file);

            // ตรวจสอบการคอมไพล์(มีไฟล์ Main.class ไหม)
            if (file_exists("$folder_ans/Main.class")) {
                $input_file = "";
                // คิวรี่ ไฟล์อินพุทของข้อสอบ
                if($request->mode == "exam") {
                    $exam = Exam::find($request->exam_id);
                    $input_file = $exam->exam_inputfile;
                }

                // รันโค้ดที่ส่ง
                $lines_run = $this->run_code($folder_ans, $file, $input_file);

                // ตรวจสอบคำตอบ
                $checker = "";
                if($request->mode == "exam") {
                    $checker = $this->check_correct_ans_ex($lines_run, $request->exam_id);
                }

                // เครียร์ไฟล์ขยะ (*.class, *.bat)
                $this->clearFolderAns($folder_ans);

                // อัพเดตสถานะการส่ง เป็นสถานะที่เช็คได้
                if($request->mode == "exam"){
                    $status = $this->update_resexam($request->pathExamID,$request->exam_id,$checker);
                }
            } else {
                // ไม่พบไฟล์ Main.class
                // อัพเดตสถานะการส่ง เป็น complie error
                if($request->mode == "exam"){
                    $checker = array("status" => "c", "res_run" => null, "time" => null, "mem" => null);
                    $status = $this->update_resexam($request->pathExamID,$request->exam_id,$checker);
                }
            }
        } else {
            // ถ้าไม่พบเมธอด main() ในโค้ดที่ส่ง
            // ตรวจสอบว่า เป็นข้อสอบเขียนคลาส หรือไม่
            $file_main = "";
            $exam = "";
            if($request->mode == "exam") {
                $exam = Exam::find($request->exam_id);
            }
            $file_main = $exam->main_code;

            if ($file_main) {
                // อ่านโค้ดในไฟล์
                $myfile = fopen($file_main, 'r');
                $origin_code = fread($myfile, filesize($file_main));
                fclose($myfile);

                // แก้ชื่อคลาสเป็น Main
                $class_name = $this->get_class_name($origin_code);
                $pos_begin_class_name = strpos($origin_code, $class_name);
                $new_class_code = substr_replace($origin_code, "Main", $pos_begin_class_name, strlen($class_name));

                // เพิ่มโค้ดส่วนการเช็คลูป เช็คเมมโมรี่ เช็คเวลา
                $code_add_checker = $this->add_check_code($new_class_code);

                // เก็บไว้ในไฟล์ชื่อ Main.java
                $file = "Main";
                $handle = fopen("$folder_ans/$file.java", 'w') or die('Cannot open file:  ' . $file);
                fwrite($handle, $code_add_checker);

                // คอมไพล์โค้ดที่ส่ง
                $this->compile_code($folder_ans, $file);

                // ตรวจสอบการคอมไพล์(มีไฟล์ Main.class ไหม)
                if (file_exists("$folder_ans/Main.class")) {
                    // คิวรี่ ไฟล์อินพุทของข้อสอบ
                    $input_file = $exam->exam_inputfile;

                    // รันโค้ดที่ส่ง
                    $lines_run = $this->run_code($folder_ans, $file, $input_file);

                    // ตรวจสอบคำตอบ
                    $checker = $this->check_correct_ans_ex($lines_run, $request->exam_id);

                    // เครียร์ไฟล์ขยะ (*.class, *.bat)
                    $this->clearFolderAns($folder_ans);

                    // ตรวจสอบคำตอบ
                    $checker = "";
                    if($request->mode == "exam") {
                        $checker = $this->check_correct_ans_ex($lines_run, $request->exam_id);
                    }

                    // เครียร์ไฟล์ขยะ (*.class, *.bat)
                    $this->clearFolderAns($folder_ans);

                    // อัพเดตสถานะการส่ง เป็นสถานะที่เช็คได้
                    if($request->mode == "exam"){
                        $status = $this->update_resexam($request->pathExamID,$request->exam_id,$checker);
                    }
                } else {
                    // ไม่พบไฟล์ Main.class
                    // อัพเดตสถานะการส่ง เป็น complie error
                    if($request->mode == "exam"){
                        $checker = array("status" => "c", "res_run" => null, "time" => null, "mem" => null);
                        $status = $this->update_resexam($request->pathExamID,$request->exam_id,$checker);
                    }
                }
            } else{
                // ไม่เจอ method main
                if($request->mode == "exam"){
                    $checker = array("status" => "c", "res_run" => null, "time" => null, "mem" => null);
                    $status = $this->update_resexam($request->pathExamID,$request->exam_id,$checker);
                }
            }
        }
        return response()->json($status);
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

    function is_main($file) {
        $myfile = fopen($file, 'r') or die('ERROR_CODE : UNABLE_TO_OPEN_FILE');
        $code = fread($myfile, filesize($file));
        fclose($myfile);

        if (strpos($code, 'main') != FALSE) {
            return true;
        }
        return false;
    }

    // JCP process code function
    function add_check_code($code) {
        $str_check_code = ' static TimerThread timeThr = new TimerThread();
                        static RunThread runThr = new RunThread();
                        static class TimerThread extends Thread {
                            public void run() {
                                try {
                                    sleep(3000);
                                    runThr.stop();
                                    System.out.println("OverTime");
                                    System.exit(0);
                                } catch (InterruptedException e) {}
                            }
                        }
                        static class RunThread extends Thread {
                            public void run() {
                                long start = System.currentTimeMillis();
                                Runtime runtime = Runtime.getRuntime();
                                runtime.gc();
                                long mem = runtime.totalMemory() - runtime.freeMemory();
                                long memNow = runtime.totalMemory() - runtime.freeMemory() - mem;
                                System.out.println("UsedMem:" + memNow/1024.0);
                                long time = System.currentTimeMillis() - start;
                                timeThr.stop();
                                System.out.println("RunTime:" + time / 1000.0);
                            }
                        }';

        // เก็บโค้ด ที่อยู่ในเมธอด main
        $code_in_main = $this->get_code_in_main($code);

        // นำโค้ดที่อยู่ในเมธอด main ใส่ในเทรดการรัน
        $pos_add_code = strpos($str_check_code, "long memNow") - 1;
        $check_code = substr_replace($str_check_code, $code_in_main["code"], $pos_add_code, 0);

        // ตัดโค้ด ที่อยู่ในเมธอด main ออก
        $code_cut_in_main = str_replace($code_in_main["code"], "", $code);

        // เพิ่มโค้ด สั่งรันเทรด ให้เมธอด main
        $code_add_in_main = substr_replace($code_cut_in_main, "timeThr.start(); runThr.start();", $code_in_main["begin"], 0);

        // เพิ่มโค้ดที่ใช้เช็คหน่วยความจำ เวลา และลูปไม่รู้จบ
        $pos_bracket_class = strpos($code_add_in_main, "{");
        $complet_code = substr_replace($code_add_in_main, $check_code, $pos_bracket_class + 1, 0);

        return $complet_code;
    }

    function get_code_in_main($code) {
        $res = array();

        $pos_main = strpos($code, "main");
        $code_from_main = substr($code, $pos_main);

        $pos_bracket_main = strpos($code_from_main, "{") + $pos_main;
        $braket = array();

        for ($i = $pos_bracket_main; $i < strlen($code); $i++) {
            if ($code[$i] == "{") {
                array_push($braket, "{");
            } else if ($code[$i] == "}") {
                array_pop($braket);
                if (empty($braket)) {
                    $res["begin"] = $pos_bracket_main + 1;
                    $res["length"] = $i - $pos_bracket_main - 1;
                    $res["code"] = substr($code, $res["begin"], $res["length"]);
                    return $res;
                }
            }
        }
        return FALSE;
    }

    function compile_code($folder_code, $file_main) {
//        ค้าหาพาร์ทของไฟล์ที่จะคอมไฟล์
        $dir = getcwd();
        $dir_split = explode("\\",$dir);
        $dir_code = "";
        for($i = 0;$i<sizeof($dir_split)-1;$i++){
            $dir_code = $dir_code.$dir_split[$i]."\\";
        }
        $dir_split = explode("/",$folder_code);
        for($i = 1;$i<sizeof($dir_split);$i++){
            $dir_code = $dir_code.$dir_split[$i]."\\";
        }
        $cmd = "cd $dir_code";

        // สร้างไฟล์ .bat สำหรับการคอมไพล์
        $file_bat = 'complie.bat';
        $openfile = fopen("$folder_code/$file_bat", 'w');
        fwrite($openfile, $cmd . " \n javac -encoding UTF8 $file_main.java");
        fclose($openfile);

        exec($dir_code.$file_bat);
    }

    function run_code($folder_code, $file_main, $input_file) {
        $dir = getcwd();
        $dir_split = explode("\\",$dir);

        // พาร์ทของข้อสอบ
        $dir_exam = "";
        for($i = 0;$i<sizeof($dir_split)-1;$i++){
            $dir_exam = $dir_exam.$dir_split[$i]."\\";
        }
        $dir_split = explode("/",$folder_code);
        for($i = 1;$i<sizeof($dir_split);$i++){
            $dir_exam = $dir_exam.$dir_split[$i]."\\";
        }
        $cmd = "cd $dir_exam";


        // สร้างไฟล์ .bat สำหรับการรัน
        $file_bat = 'run.bat';
        $openfile = fopen("$folder_code/$file_bat", 'w');
        if ($input_file) {
            // พาร์ทของ input file
            $dir_input = "";
            $dir_split = explode("\\",$dir);
            for($i = 0;$i<sizeof($dir_split)-1;$i++){
                $dir_input = $dir_input.$dir_split[$i]."\\";
            }
            $dir_split = explode("/",$input_file);
            for($i = 1;$i<sizeof($dir_split)-1;$i++){
                $dir_input = $dir_input.$dir_split[$i]."\\";
            }
            $dir_input = $dir_input.$dir_split[sizeof($dir_split)-1];

            fwrite($openfile, $cmd . " \n java $file_main < " . $dir_input);
        } else {
            fwrite($openfile, $cmd . " \n java $file_main");
        }
        fclose($openfile);

        $lines_run = array();
        exec($dir_exam.$file_bat, $lines_run);
        return $lines_run;
    }

    function check_correct_ans_ex($lines_run, $exam_id) {
        $exam = Exam::find($exam_id);
        $run = $this->prepare_result($lines_run);

        if ($run == 'OverTime') {
            return array("status" => "t", "res_run" => 'Over time', "time" => 0, "mem" => 0);
        } else if ($run['mem'] > $exam->memory_size) {
            return array("status" => "m", "res_run" => 'Over memory', "time" => $run['time'], "mem" => $run['mem']);
        } else if ($run['time'] > $exam->time_limit) {
            return array("status" => "t", "res_run" => 'Over time', "time" => $run['time'], "mem" => $run['mem']);
        } else {
            // อ่านไฟล์ output ของ Teacher
            $file_output = $exam->exam_outputfile;
            $output_teacher = file($file_output);

            // คิดคำตอบเหมือน output กี่เปอร์เซ็นต์
            $percent_equal = $this->check_percentage_ans($output_teacher, $run['res_run'], $exam->case_sensitive);

            if ($percent_equal == 100) {
                return array("status" => "a", "res_run" => $this->arr_to_code($run['res_run']), "time" => $run['time'], "mem" => $run['mem']);
            } else if ($percent_equal > 89) {
                return array("status" => "9", "res_run" => $this->arr_to_code($run['res_run']), "time" => $run['time'], "mem" => $run['mem']);
            } else if ($percent_equal > 79) {
                return array("status" => "8", "res_run" => $this->arr_to_code($run['res_run']), "time" => $run['time'], "mem" => $run['mem']);
            } else if ($percent_equal > 69) {
                return array("status" => "7", "res_run" => $this->arr_to_code($run['res_run']), "time" => $run['time'], "mem" => $run['mem']);
            } else if ($percent_equal > 59) {
                return array("status" => "6", "res_run" => $this->arr_to_code($run['res_run']), "time" => $run['time'], "mem" => $run['mem']);
            } else if ($percent_equal > 49) {
                return array("status" => "5", "res_run" => $this->arr_to_code($run['res_run']), "time" => $run['time'], "mem" => $run['mem']);
            }

            // ถ้าน้อยกว่า 50% ถือว่า wrong answer
            return array("status" => "w", "res_run" => $this->arr_to_code($run['res_run']), "time" => $run['time'], "mem" => $run['mem']);
        }
    }

    function prepare_result($lines_run) {
        $iMem = $iTime = $iOverTime = -1;
        $res_run = '';

        for ($i = 4; $i < count($lines_run); $i++) {
            $line = $lines_run[$i];
            if (strpos($line, "UsedMem:") > -1) {
                $iMem = $i;
            } else if (strpos($line, "RunTime:") > -1) {
                $iTime = $i;
            } else if (strpos($line, "OverTime") > -1) {
                $iOverTime = $i;
            }
        }

        if ($iOverTime > -1) {
            return "OverTime";
        } else if ($iMem > -1 && $iTime > -1) {
            $res_run = array_slice($lines_run, 4, $iMem - 4);
            $i = 0;
            foreach ($res_run as $val) {
                $res_run[$i++] = iconv(mb_detect_encoding($val), "utf-8", $val);
            }

            $mem = substr($lines_run[$iMem], 8);
            $time = substr($lines_run[$iTime], 8);

            return array('res_run' => $res_run, 'mem' => $mem, 'time' => $time);
        }
    }

    function check_percentage_ans($output_teacher, $output_run, $is_case_sensitive) {

        // เช็คจำนวนแถว output ที่รันได้ไม่เกิน output ตรวจสอบใช่ไหม
        if (count($output_run) <= count($output_teacher)) {
            $count_check = 0;
            for ($i = 0; $i < count($output_run); $i++) { // เช็คว่าคำตอบทั้ง 2 ไฟล์ ตรงกันหรือไม่
                // ในกรณีไม่คิด Case sensitive
                if (!$is_case_sensitive) {
                    $output_run[$i] = strtolower($output_run[$i]);
                    $output_teacher[$i] = strtolower($output_teacher[$i]);
                }
                if (trim($output_run[$i]) == trim($output_teacher[$i])) {
                    $count_check++;
                }
            }

            if ($count_check == count($output_teacher)) {
                return 100;
            } else {
                return $count_check * 100 / count($output_teacher);
            }
        } else {
            // output ที่รันได้ มีจำนวนมากกว่า output ตรวจสอบ
            return 0;
        }
    }

    function arr_to_code($res_run) {
        $str = '';
        for ($i = 0; $i < count($res_run) - 1; $i++) {
            $str .= ($res_run[$i] . PHP_EOL);
        }
        $str .= $res_run[$i];
        return $str;
    }

    function clearFolderAns($folder_ans) {
        $files = scandir($folder_ans);

        // ลูปลบไฟล์ที่นามสกุลไม่ใช่ .java และ Main.java
        foreach ($files as $f) {
            if (!strpos($f, '.java') || $f == 'Main.java') {
                @unlink("$folder_ans/$f");
            }
        }
    }

    function update_resexam($path_exam_id, $exam_id, $checker) {

        $exam = Exam::find($exam_id);

        $resExamID = "";
        // อัพเดทข้อมูลใน table path_exam
        $pathExam = PathExam::find($path_exam_id);
        $resExamID = $pathExam->resexam_id;
        $pathExam->resrun = $checker["res_run"];
        $pathExam->status = $checker["status"];
        $pathExam->time = $checker["time"];
        $pathExam->memory = $checker["mem"];
        $pathExam->save();

        // ค้นคำตอบที่มีเปอร์เซ็นถูกต้องเยอะที่สุด จากที่เคยส่ง
        $statusImp = DB::select('SELECT status 
                                  FROM (SELECT * FROM path_exams WHERE path_exams.resexam_id = ?) AS s 
                                  WHERE s.status = "9" 
                                  OR s.status = "8" 
                                  OR s.status = "7" 
                                  OR s.status = "6" 
                                  OR s.status = "5" 
                                  GROUP BY s.status',[$resExamID]);
        $maxPercent = 0;
        if($statusImp){
            foreach($statusImp as $status){
                if($status->status == 9) {
                    if($maxPercent < 9) $maxPercent = 9;
                } else if ($status->status == 8){
                    if($maxPercent < 8) $maxPercent = 8;
                } else if ($status->status == 7){
                    if($maxPercent < 7) $maxPercent = 7;
                } else if ($status->status == 6){
                    if($maxPercent < 6) $maxPercent = 6;
                } else if ($status->status == 5){
                    if($maxPercent < 5) $maxPercent = 5;
                }
            }
        }

        $cutScore = 0;
        // ค้นหาการส่งข้อสอบ
        $resExam = ResExam::find($resExamID);
        $resExam->current_status = $checker["status"];
        
        // คำนวนคะแนนที่ต้องถูกหัก
        $cutScore = ($exam->cut_wrongans*$resExam->sum_wrong)+($exam->cut_comerror*$resExam->sum_comerror)+($exam->cut_overmemory*$resExam->sum_overmem)+($exam->cut_overtime*$resExam->sum_overtime);
        
        // ถ้าสถานะเป็น ผ่าน หรือ ถูกต้องบางส่วน
        $score = 0;
        if ($checker['status'] == 'a' || is_numeric($checker['status'])) {
            if($checker['status'] == 'a'){
                $score = $exam->full_score;
                $resExam->sum_accep = $resExam->sum_accep+1;
            } else {
                if($checker['status'] > $maxPercent){
                    $score = $exam->full_score * $checker['status'] / 10;
                } else {
                    $score = $exam->full_score * $maxPercent / 10;
                }
                $resExam->sum_imp = $resExam->sum_imp+1;
            }
        } else {
            $score = $exam->full_score * $maxPercent / 10;
            if($checker['status'] == 'w'){
                $cutScore += $exam->cut_wrongans;
                $resExam->sum_wrong = $resExam->sum_wrong+1;
            }
            else if($checker['status'] == 't'){
                $cutScore += $exam->cut_overtime;
                $resExam->sum_overtime = $resExam->sum_overtime+1;
            }
            else if($checker['status'] == 'm'){
                $cutScore += $exam->cut_overmemory;
                $resExam->sum_overmem = $resExam->sum_overmem+1;
            }
            else if($checker['status'] == 'c'){
                $cutScore += $exam->cut_comerror;
                $resExam->sum_comerror = $resExam->sum_comerror+1;
            }
        }
        $resExam->score = $score - $cutScore > 0 ? $score - $cutScore : 0;
        $resExam->save();
        return $checker['status'];
    }

    function makeFolder($path,$folder) {
        $dirList = scandir($path);
        if (!in_array((string) $folder, (array) $dirList)) {
            mkdir($path.$folder, 0777, true);
        }
    }

    public function test()
    {
       $path = "../upload/resexam/";
        return response()->json(explode("/",$path)[2] == "resexam");
    }

}
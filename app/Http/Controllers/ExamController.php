<?php

namespace App\Http\Controllers;

use App\Keyword;
use Dotenv\Validator;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Section;
use App\Exam;
use phpDocumentor\Reflection\Types\Null_;

class ExamController extends Controller
{
    public function index()
    {
//        $sections = DB::table('sections')
//            ->join('users', 'sections.personal_id', '=', 'users.personal_id')
//            ->select('sections.*', 'users.prefix', 'users.fname_th' , 'users.lname_th')
//            ->get();


//        foreach($sections as $section) {
//            $section->prefix = utf8_decode($section->prefix);
//            $section->fname_th = utf8_decode($section->fname_th);
//            $section->lname_th = utf8_decode($section->lname_th);
//        }
        $findAllSection = Section::orderBy('section_name')->get();
        $data = array(
            'sections' => $findAllSection
        );

        return view('pages/exam',$data);
    }

    public function findAllExam()
    {
        //
        $findAllExam = Exam::all();
        return response()->json($findAllExam);
    }

    public function checkExamByName(Request $request)
    {
        $findExam = Exam::where('exam_name',$request->exam_name)
            ->where('section_id',$request->sections_id)
            ->where('user_id',$request->user_id)
            ->first();
        if ($findExam === NULL) {
//             return true;
        }else{
            return response()->json(['error' => 'Error msg'], 209);
        }
//         return response()->json($request);

    }

    public function createTextFile(Request $request)
    {
        $part = "upload/exam/";
        if($request->status == "input")$part = $part."input/";
        else if($request->status == "output")$part = $part."output/";
        else if($request->status == "main")$part = $part."main/";
        $file_up = $part . date('Ymd-His') . '_' . rand(1, 9999);
        $file_up = "$file_up.txt";
        $myfile = fopen($file_up, "w") or die("Unable to open file!");
//        $txt = $request->content;
        fwrite($myfile, $request->content);
        fclose($myfile);
        return response()->json($file_up);
    }

    public function uploadFile(Request $req)
    {
        if($req->hasFile('exam_file_input')) {
            $file = $req->file('exam_file_input');
            $fileName = date('Ymd-His') . '_' . rand(1, 9999).".txt";
            $file->move('upload/exam/input/' , $fileName);
            return response()->json('upload/exam/input/'.$fileName);
        }

        if($req->hasFile('exam_file_output')) {
            $file = $req->file('exam_file_output');
            $fileName = date('Ymd-His') . '_' . rand(1, 9999).".txt";
            $file->move('upload/exam/output/' , $fileName);
            return response()->json('upload/exam/output/'.$fileName);
        }
    }


    public function create($id)
    {
        $data = array(
            'groupID' => $id
        );
        return view('pages/addExam',$data);
    }


    public function store(Request $request)
    {
        $exam = new Exam;
        $exam->user_id = $request->user_id;
        $exam->section_id = $request->section_id;
        $exam->exam_name = $request->exam_name;
        $exam->exam_data = $request->exam_data;
        $exam->exam_inputfile = $request->exam_inputfile;
        $exam->exam_outputfile = $request->exam_outputfile;
        $exam->memory_size = $request->memory_size;
        $exam->time_limit = $request->time_limit;
        $exam->full_score = $request->full_score;
        $exam->accep_imperfect = $request->accep_imperfect;
        $exam->cut_wrongans = $request->cut_wrongans;
        $exam->cut_comerror = $request->cut_comerror;
        $exam->cut_overmemory = $request->cut_overmemory;
        $exam->cut_overtime = $request->cut_overtime;
        $exam->main_code = $request->main_code;
        $exam->case_sensitive = $request->case_sensitive;
        $exam->save();

        $exam = Exam::where('user_id',$request->user_id)
            ->where('exam_name',$request->exam_name)->first();

        return response()->json($exam);

    }

    public function readFile(Request $request)
    {
        $contentFile = fopen("$request->exam_data", "r") or die("Unable to open file!");
        $content = fread($contentFile,filesize("$request->exam_data"));
        fclose($contentFile);

        if($request->exam_inputfile != NULL){
            $inputFile = fopen("$request->exam_inputfile", "r") or die("Unable to open file!");
            $input = fread($inputFile,filesize("$request->exam_inputfile"));
            fclose($inputFile);
        }else {
            $input = "";
        }

        $outputFile = fopen("$request->exam_outputfile", "r") or die("Unable to open file!");
        $output = fread($outputFile,filesize("$request->exam_outputfile"));
        fclose($outputFile);

        if($request->main_code != NULL){
            $mainCodeFile = fopen("$request->main_code", "r") or die("Unable to open file!");
            $main_code = fread($mainCodeFile,filesize("$request->main_code"));
        } else {
            $main_code = "";
        }

        $data = array(
            'content' => $content,
            'input' => $input,
            'output' => $output,
            'main' => $main_code
        );

        return response()->json($data);
    }


    public function show($id)
    {
        $exam = Exam::find($id);
        return response()->json($exam);
    }


    public function edit($id)
    {
        $data = array(
            'examId' => $id
        );
        return view('pages/editExam',$data);
    }


    public function update(Request $request)
    {
        $exam = Exam::find($request->id);
        @unlink("$exam->exam_data");

        if($exam->exam_inputfile != NULL) {
            @unlink("$exam->exam_inputfile");
        }

        @unlink("$exam->exam_outputfile");

        if($exam->main_code != NULL) {
            @unlink("$exam->main_code");
        }

        $exam->section_id = $request->section_id;
        $exam->exam_name = $request->exam_name;
        $exam->exam_data = $request->exam_data;
        $exam->exam_inputfile = $request->exam_inputfile;
        $exam->exam_outputfile = $request->exam_outputfile;
        $exam->memory_size = $request->memory_size;
        $exam->time_limit = $request->time_limit;
        $exam->full_score = $request->full_score;
        $exam->accep_imperfect = $request->accep_imperfect;
        $exam->cut_wrongans = $request->cut_wrongans;
        $exam->cut_comerror = $request->cut_comerror;
        $exam->cut_overmemory = $request->cut_overmemory;
        $exam->cut_overtime = $request->cut_overtime;
        $exam->main_code = $request->main_code;
        $exam->case_sensitive = $request->case_sensitive;
        $exam->save();


    }

    public function destroy($id)
    {
        $exam = Exam::find($id);

        @unlink("$exam->exam_data");

        if($exam->exam_inputfile != NULL) {
            @unlink("$exam->exam_inputfile");
        }

        @unlink("$exam->exam_outputfile");

        if($exam->main_code != NULL) {
            @unlink("$exam->main_code");
        }

        $exam->delete();
    }
}

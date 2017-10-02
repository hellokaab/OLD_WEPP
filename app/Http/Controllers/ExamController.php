<?php

namespace App\Http\Controllers;

use App\Keyword;
use DirectoryIterator;
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
//        $findAllSection = Section::orderBy('section_name')->get();
//        $data = array(
//            'sections' => $findAllSection
//        );

        return view('pages/teacher/exam');
    }

    public function myExam(){
        return view('pages/teacher/myExam');
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
        $path = str_replace("*","/",$request->path);;
        if($request->status == "input")$file_up = $path."input.txt";
        else if($request->status == "output")$file_up = $path."output.txt";
        else if($request->status == "main")$file_up = $path."main.txt";
        $myfile = fopen($file_up, "w") or die("Unable to open file!");
        fwrite($myfile, $request->content);
        fclose($myfile);
        return response()->json($file_up);
    }

    public function uploadFile($path,Request $req)
    {
        $pathExam = str_replace("*","/",$path);

        if($req->hasFile('exam_file_input')) {
            $file = $req->file('exam_file_input');
            $fileName = "input.txt";
            $file->move($pathExam , $fileName);
            return response()->json($pathExam.$fileName);
        }

        if($req->hasFile('exam_file_output')) {
            $file = $req->file('exam_file_output');
            $fileName = "output.txt";
            $file->move($pathExam , $fileName);
            return response()->json($pathExam.$fileName);
        }
    }


    public function create($id)
    {
        $data = array(
            'groupID' => $id
        );
        return view('pages/teacher/addExam',$data);
    }

    public function copyExam($id){
        $data = array(
            'examId' => $id
        );
        return view('pages/teacher/copyExam',$data);
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

    public function readExamContent(Request $request)
    {
        $contentFile = fopen("$request->exam_data", "r") or die("Unable to open file!");
        $content = fread($contentFile,filesize("$request->exam_data"));


        return response()->json($content);
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
        return view('pages/teacher/editExam',$data);
    }


    public function update(Request $request)
    {
        $folderPath = "";
        $exam = Exam::find($request->id);
        $getpath = explode("/",$exam->exam_data);
        for($i=0;$i<sizeof($getpath)-1;$i++){
            $folderPath = $folderPath.$getpath[$i]."/";
        }
        $this->rrmdir($folderPath);
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
        $folderPath = "";
        $getpath = explode("/",$exam->exam_data);
        for($i=0;$i<sizeof($getpath)-1;$i++){
            $folderPath = $folderPath.$getpath[$i]."/";
        }
        $this->rrmdir($folderPath);

        $exam->delete();
    }

    public function rrmdir($path) {
        // Open the source directory to read in files
        $i = new DirectoryIterator($path);
        foreach ($i as $f) {
            if ($f->isFile()) {
                unlink($f->getRealPath());
            } else if (!$f->isDot() && $f->isDir()) {
                $this->rrmdir($f->getRealPath());
            }
        }
        rmdir($path);
    }
}

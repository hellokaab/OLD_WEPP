<?php

namespace App\Http\Controllers;

//use App\Worksheet;
use App\Quiz;
use App\ResSheet;
use App\ShareWorksheet;
use App\Users;
use App\Worksheet;
use App\WorksheetGroup;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use DirectoryIterator;

class WorkSheetController extends Controller
{
    public function myWorksheet()
    {
        return view('pages/teacher/myWorksheet');
    }
    public function shareWorksheet()
    {
        return view('pages/teacher/shareWorksheet');
    }

    public function addMyWorksheetGroup(Request $request)
    {
        $findWorksheetName = WorksheetGroup::where('sheet_group_name', $request->sheet_name)
            ->where('user_id',$request->user_id)
            ->first();
        if ($findWorksheetName === NULL) {
            $worksheet = new WorksheetGroup();
            $worksheet->user_id = $request->user_id;
            $worksheet->sheet_group_name = $request->sheet_name;
            $worksheet->save();
        } else {
            return response()->json(['error' => 'Error msg'], 209);
        }
    }
    public function findMySheetGroup(Request $request) //Request $request->id
    {
        $dataSheetGroup = DB::table('worksheet_groups')
            ->join('users', 'worksheet_groups.user_id', '=', 'users.id')
            ->select('worksheet_groups.*', 'users.prefix', 'users.fname_th', 'users.lname_th')
            ->where('worksheet_groups.user_id', $request->id)
            ->orderBy('sheet_group_name', 'ASC')
            ->get();
        return response()->json($dataSheetGroup);
    }

    public function destroy(Request $request)
    {
        $worksheet = WorksheetGroup::find($request->id);
        $user = Users::find($worksheet->user_id);
        $userFolder = $user->id."_".$user->fname_en."_".$user->lname_en;
        $sectionFolder = "SheetGroup_".$worksheet->id;
        $this->rrmdir("../upload/worksheet/".$userFolder."/".$sectionFolder);
        $worksheet->delete();

    }

    public function editSheetGroup(Request $request)
    {
        $findWorksheetName = WorksheetGroup::where('sheet_group_name', $request->sheet_name)
        ->where('user_id', $request->user_id)
        ->first();

        if ($findWorksheetName === NULL) {
            $worksheet = WorksheetGroup::find($request->id);
            $worksheet->sheet_group_name = $request->sheet_name;
            $worksheet->save();
        } else {
            if ($findWorksheetName->id == $request->id) {
                $worksheet = WorksheetGroup::find($request->id);
                $worksheet->sheet_group_name = $request->sheet_name;
                $worksheet->save();
            } else {
                return response()->json(['error' => 'Error msg'], 209);
            }
        }
    }
    public function addWorksheet($id)
    {
        $data = array(
            'sheetGroupId' => $id
        );
        return view('pages/teacher/addWorksheet', $data);
    }

    public function editWorksheet($id)
    {
        $data = array(
            'sheetID' => $id
        );
        return view('pages/teacher/editWorksheet',$data);
    }

    public function copyWorksheet($id)
    {
        $data = array(
            'sheetID' => $id
        );
        return view('pages/teacher/copyWorksheet',$data);
    }

    public function findSheetByName(Request $request)
    {
        $findSheet = Worksheet::where('sheet_name',$request->sheet_name)
            ->where('sheet_group_id',$request->sheet_group_id)
            ->where('user_id',$request->user_id)
            ->first();
        if ($findSheet === NULL) {
//             return true;
        }else{
            return response()->json(['error' => 'Error msg'], 209);
        }
    }

    public function createWorksheet(Request $request){
        $sheet = new Worksheet;
        $sheet->user_id = $request->user_id;
        $sheet->sheet_group_id = $request->sheet_group_id;
        $sheet->sheet_name = $request->sheet_name;
        $sheet->objective = $request->objective;
        $sheet->theory = $request->theory;
        $sheet->notation = $request->notation;
        $sheet->sheet_trial = $request->sheet_trial;
        $sheet->sheet_input_file = $request->sheet_input_file;
        $sheet->sheet_output_file = $request->sheet_output_file;
        $sheet->main_code = $request->main_code;
        $sheet->case_sensitive = $request->case_sensitive;
        $sheet->full_score = $request->full_score;
        $sheet->save();
        $insertedId = $sheet->id;
        $sheetID = $insertedId;

        return response()->json($sheet);
    }

    public function uploadFileSh($path,Request $req)
    {
        $pathSheet = str_replace("*","/",$path);

        if($req->hasFile('sheet_file_input')) {
            $file = $req->file('sheet_file_input');
            $fileName = "input.txt";
            $file->move($pathSheet , $fileName);
            return response()->json($pathSheet.$fileName);
        }

        if($req->hasFile('sheet_file_output')) {
            $file = $req->file('sheet_file_output');
            $fileName = "output.txt";
            $file->move($pathSheet , $fileName);
            return response()->json($pathSheet.$fileName);
        }
    }

    public function findSheetByUserID(Request $request){
        $sheet = Worksheet::where('user_id',$request->user_id)
            ->orderBy('sheet_name','ASC')
            ->get();

        return response()->json($sheet);
    }

    public function findSheetByID(Request $request){
        $sheet = Worksheet::find($request->id);
        return response()->json($sheet);
    }

    public function createQuiz(Request $request){
        $quiz = new Quiz;
        $quiz->sheet_id = $request->sheet_id;
        $quiz->quiz_data = $request->quiz_data;
        $quiz->quiz_ans = $request->quiz_ans;
        $quiz->quiz_score = $request->quiz_score;
        $quiz->save();
    }

    public function createSharedWorksheet(Request $request){
        $shared = new ShareWorksheet;
        $shared->sheet_id = $request->sheet_id;
        $shared->user_id = $request->user_id;
        $shared->save();
    }

    public function findWorksheetByID($id){
        $sheet = Worksheet::find($id);
        return response()->json($sheet);
    }

    public function readFileSh(Request $request)
    {
        if($request->objective != NULL){
            $objectiveFile = fopen("$request->objective", "r") or die("Unable to open file!");
            $objective = fread($objectiveFile,filesize("$request->objective"));
            fclose($objectiveFile);
        }else {
            $objective = "";
        }

        if($request->theory != NULL){
            $theoryFile = fopen("$request->theory", "r") or die("Unable to open file!");
            $theory = fread($theoryFile,filesize("$request->theory"));
            fclose($theoryFile);
        }else {
            $theory = "";
        }

        $trialFile = fopen("$request->sheet_trial", "r") or die("Unable to open file!");
        $trial = fread($trialFile,filesize("$request->sheet_trial"));
        fclose($trialFile);

        if($request->sheet_input_file != NULL){
            $inputFile = fopen("$request->sheet_input_file", "r") or die("Unable to open file!");
            $input = fread($inputFile,filesize("$request->sheet_input_file"));
            fclose($inputFile);
        }else {
            $input = "";
        }

        $outputFile = fopen("$request->sheet_output_file", "r") or die("Unable to open file!");
        $output = fread($outputFile,filesize("$request->sheet_output_file"));
        fclose($outputFile);

        if($request->main_code != NULL){
            $mainCodeFile = fopen("$request->main_code", "r") or die("Unable to open file!");
            $main_code = fread($mainCodeFile,filesize("$request->main_code"));
        } else {
            $main_code = "";
        }

        $data = array(
            'objective' => $objective,
            'theory' => $theory,
            'trial' => $trial,
            'input' => $input,
            'output' => $output,
            'main' => $main_code
        );
        return response()->json($data);
    }

    public function findSheetSharedUserNotMe(Request $request){
        $shared = DB::table('share_worksheets')
            ->where('sheet_id',$request->sheet_id)
            ->where('user_id', '!=',$request->my_id)
            ->get();
        return response()->json($shared);
    }

    public function updateWorksheet(Request $request){
        $folderPath = "";
        $sheet = Worksheet::find($request->id);
        $getpath = explode("/",$sheet->sheet_trial);
        for($i=0;$i<sizeof($getpath)-1;$i++){
            $folderPath = $folderPath.$getpath[$i]."/";
        }
        $this->rrmdir($folderPath);
        $sheet->sheet_group_id = $request->sheet_group_id;
        $sheet->sheet_name = $request->sheet_name;
        $sheet->objective = $request->objective;
        $sheet->theory = $request->theory;
        $sheet->notation = $request->notation;
        $sheet->sheet_trial = $request->sheet_trial;
        $sheet->sheet_input_file = $request->sheet_input_file;
        $sheet->sheet_output_file = $request->sheet_output_file;
        $sheet->main_code = $request->main_code;
        $sheet->case_sensitive = $request->case_sensitive;
        $sheet->full_score = $request->full_score;
        $sheet->save();
    }

    public function deleteUserSharedSheet(Request $request){
        $selectShared = DB::table('share_worksheets')
            ->where('sheet_id',$request->sheet_id)
            ->where('user_id',$request->user_id)
            ->first();
        $delShared = ShareWorksheet::find($selectShared->id);
        $delShared->delete();
    }

    public function updateSharedSheet(Request $request){
        $shared = ShareWorksheet::where('sheet_id',$request->sheet_id)
            ->where('user_id',$request->user_id)
            ->first();
        if ($shared === NULL) {
            $newShared = new ShareWorksheet;
            $newShared->sheet_id = $request->sheet_id;
            $newShared->user_id = $request->user_id;
            $newShared->save();
        }
    }

    public function updateQuiz(Request $request){
        $quiz = Quiz::find($request->id);
        $quiz->quiz_data = $request->quiz_data;
        $quiz->quiz_ans = $request->quiz_ans;
        $quiz->quiz_score = $request->quiz_score;
        $quiz->save();
    }

    public function deleteQuiz(Request $request){
        $quiz = Quiz::find($request->id);
        $quiz->delete();
    }

    public function deleteWorksheet($id){
        $sheet = Worksheet::find($id);
        $folderPath = "";
        $getpath = explode("/",$sheet->sheet_trial);
        for($i=0;$i<sizeof($getpath)-1;$i++){
            $folderPath = $folderPath.$getpath[$i]."/";
        }
        $this->rrmdir($folderPath);
        $sheet->delete();
    }

    public function findSheetGroupSharedNotMe(Request $request){
        $worksheet_groups = DB::table('share_worksheets')
            ->join('worksheets', 'share_worksheets.sheet_id', '=', 'worksheets.id')
            ->join('worksheet_groups', 'worksheets.sheet_group_id', '=', 'worksheet_groups.id')
            ->join('users', 'worksheet_groups.user_id', '=', 'users.id')
            ->select('worksheet_groups.*', DB::raw('CONCAT("อ.",users.fname_th," ", users.lname_th) AS creater'))
            ->where('share_worksheets.user_id',$request->my_id)
            ->where('worksheet_groups.user_id','!=',$request->my_id)
            ->groupBy('worksheet_groups.id')
            ->orderBy('creater', 'asc')
            ->orderBy('worksheet_groups.sheet_group_name', 'asc')
            ->get();
        return response()->json($worksheet_groups);
    }

    public function findSheetSharedToMe(Request $request){
        $sheet = DB::table('share_worksheets')
            ->join('worksheets', 'share_worksheets.sheet_id', '=', 'worksheets.id')
            ->select('worksheets.*')
            ->where('share_worksheets.user_id',$request->my_id)
            ->orderBy('worksheets.sheet_name', 'asc')
            ->get();
        return response()->json($sheet);
    }

    public function readSheetTrial(Request $request)
    {
        $contentFile = fopen("$request->sheet_trial", "r") or die("Unable to open file!");
        $content = fread($contentFile,filesize("$request->sheet_trial"));
        return response()->json($content);
    }

    public function findQuizBySID(Request $request){
        $quiz = Quiz::where('sheet_id',$request->sheet_id)->get();
        return response()->json($quiz);
    }

    public function rrmdir($path) {
        // Open the source directory to read in files
        try {
            $i = new DirectoryIterator($path);
            foreach ($i as $f) {
                if ($f->isFile()) {
                    unlink($f->getRealPath());
                } else if (!$f->isDot() && $f->isDir()) {
                    $this->rrmdir($f->getRealPath());
                }
            }
            rmdir($path);
        } catch(\Exception $e ){}
    }
}


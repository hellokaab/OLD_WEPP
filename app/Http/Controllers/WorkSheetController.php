<?php

namespace App\Http\Controllers;

//use App\Worksheet;
use App\Worksheet;
use App\WorksheetGroup;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

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
    public function dataSheetGroup(Request $request) //Request $request->id
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
        $worksheet->delete();
        //
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
}


<?php

namespace App\Http\Controllers;

//use App\Worksheet;
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
        return view('pages/shareWorksheet');
    }
    public function addMyWorksheetGroup(Request $request)
    {
        $findWorksheetName = WorksheetGroup::where('sheetName_group', $request->sheet_name)
            ->where('user_id',$request->user_id)
            ->first();
        if ($findWorksheetName === NULL) {
            $worksheet = new WorksheetGroup();
            $worksheet->user_id = $request->user_id;
            $worksheet->sheetName_group = $request->sheet_name;
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
//            ->orderBy('group_name', 'ASC')
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
        $findWorksheetName = WorksheetGroup::where('sheetName_group', $request->sheet_name)
        ->where('user_id', $request->user_id)
        ->first();

        if ($findWorksheetName === NULL) {
            $worksheet = WorksheetGroup::find($request->id);
            $worksheet->sheetName_group = $request->sheet_name;
            $worksheet->save();
        } else {
            if ($findWorksheetName->id == $request->id) {
                $worksheet = WorksheetGroup::find($request->id);
                $worksheet->sheetName_group = $request->sheet_name;
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
}


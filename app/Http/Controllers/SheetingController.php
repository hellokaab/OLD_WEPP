<?php

namespace App\Http\Controllers;

use App\Sheeting;
use App\SheetSheeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class SheetingController extends Controller
{
    public function openWorksheet(){
        return view('pages/teacher/openWorksheet');
    }

    public function sheetingHistory(){
        return view('pages/teacher/openWorksheetHistory');
    }

    public function findSheetGroupSharedToMe(Request $request){
        $section = DB::table('share_worksheets')
            ->join('worksheets', 'share_worksheets.sheet_id', '=', 'worksheets.id')
            ->join('worksheet_groups', 'worksheets.sheet_group_id', '=', 'worksheet_groups.id')
            ->join('users', 'worksheet_groups.user_id', '=', 'users.id')
            ->select('worksheet_groups.*', DB::raw('CONCAT("อ.",users.fname_th," ", users.lname_th) AS creater'))
            ->where('share_worksheets.user_id',$request->my_id)
            ->groupBy('worksheet_groups.id')
            ->orderBy('creater', 'asc')
            ->orderBy('worksheet_groups.sheet_group_name', 'asc')
            ->get();
        return response()->json($section);
    }

    public function findSheetingByNameAndGroup(Request $request)
    {
        $sheeting = Sheeting::where('sheeting_name',$request->sheeting_name)
            ->where('group_id',$request->group_id)
            ->first();
        if ($sheeting === NULL) {
//             return true;
        }else{
            return response()->json(['error' => 'Error msg'], 209);
        }
    }

    public function createSheeting(Request $request){
        $sheeting = new Sheeting;
        $sheeting->user_id = $request->user_id;
        $sheeting->group_id = $request->group_id;
        $sheeting->sheeting_name = $request->sheeting_name;
        $sheeting->start_date_time = $request->start_date_time;
        $sheeting->end_date_time = $request->end_date_time;
        $sheeting->allowed_file_type = $request->allowed_file_type;
        $sheeting->send_late = $request->send_late;
        $sheeting->save();

        return response()->json($sheeting);
    }

    public function updateSheeting(Request $request){
        $sheeting = Sheeting::find($request->id);
        $sheeting->group_id = $request->group_id;
        $sheeting->sheeting_name = $request->sheeting_name;
        $sheeting->start_date_time = $request->start_date_time;
        $sheeting->end_date_time = $request->end_date_time;
        $sheeting->allowed_file_type = $request->allowed_file_type;
        $sheeting->send_late = $request->send_late;
        $sheeting->save();

        return response()->json($sheeting);
    }

    public function createSheetSheeting(Request $request){
        $sheetSheeting = new SheetSheeting;
        $sheetSheeting->sheet_id = $request->sheet_id;
        $sheetSheeting->sheeting_id = $request->sheeting_id;
        $sheetSheeting->save();
    }

    public function deleteSheetSheeting(Request $request){
        $sheetSheeting = DB::table('sheet_sheetings')
            ->where('sheet_id', $request->sheet_id)
            ->where('sheeting_id', $request->sheeting_id)
            ->first();
        $delEEM = SheetSheeting::find($sheetSheeting->id);
        $delEEM->delete();
    }

    public function updateSheetSheeting(Request $request)
    {
        $sheetSheeting = SheetSheeting::where('sheet_id', $request->sheet_id)
            ->where('sheeting_id', $request->sheeting_id)->first();
        if ($sheetSheeting === NULL) {
            $newSST = new SheetSheeting;
            $newSST->sheet_id = $request->sheet_id;
            $newSST->sheeting_id = $request->sheeting_id;
            $newSST->save();
        }
    }

    public function findSheetingByUserID(Request $request){
        $sheeting = Sheeting::where('user_id',$request->user_id)
            ->orderBy('start_date_time','ASC')
            ->orderBy('end_date_time','ASC')
            ->orderBy('sheeting_name','ASC')
            ->get();
        return response()->json($sheeting);
    }

    public function editOpenSheet($id){
        $data = array(
            'sheetingID' => $id
        );
        return view('pages/teacher/editSheeting',$data);
    }

    public function viewSheet($id){
        $data = array(
            'sheetingID' => $id
        );
        return view('pages/student/viewSheet',$data);
    }

    public function findSheetSheetingBySheetingID(Request $request){
        $sheetSheeting = SheetSheeting::where('sheeting_id',$request->sheeting_id)->get();
        return response()->json($sheetSheeting);
    }

    public function findSheetingByID(Request $request){
        $sheeting = Sheeting::find($request->id);
        return response()->json($sheeting);
    }

    public function deleteSheeting(Request $request){
        $sheeting = Sheeting::find($request->id);
        $sheeting->delete();
    }

    public function findSheetingByGroupID(Request $request){
        $sheeting = Sheeting::where('group_id',$request->group_id)
            ->orderBy('start_date_time','ASC')
            ->orderBy('end_date_time','ASC')
            ->get();
        return response()->json($sheeting);
    }

    public function findSheetSheetingInViewSheet(Request $request)
    {
        $sheetSheeting = DB::select('SELECT w.sheet_name,a.* 
                                    FROM worksheets AS w 
                                    INNER JOIN (
	                                    SELECT st.*,re.current_status 
	                                    FROM sheet_sheetings AS st LEFT JOIN(
                                            SELECT * 
		                                    FROM res_sheets
		                                    WHERE res_sheets.user_id = ? ) AS re
	                                    ON st.sheet_id = re.sheet_id 
	                                    WHERE st.sheeting_id = ?) AS a
                                    ON w.id = a.sheet_id', [$request->user_id,$request->sheeting_id]);
        return response()->json($sheetSheeting);
    }
}

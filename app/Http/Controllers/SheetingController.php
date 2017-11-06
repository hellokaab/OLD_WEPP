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

    public function createSheetSheeting(Request $request){
        $sheetSheeting = new SheetSheeting;
        $sheetSheeting->sheet_id = $request->sheet_id;
        $sheetSheeting->sheeting_id = $request->sheeting_id;
        $sheetSheeting->save();
    }
}

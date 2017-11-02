<?php

namespace App\Http\Controllers;

use App\Users;
use DirectoryIterator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Section;

class SectionController extends Controller
{

    public function index()
    {
        //
    }


    public function findAllSection()
    {
        $sections = DB::table('sections')
            ->join('users', 'sections.user_id', '=', 'users.id')
            ->select('sections.*', DB::raw('CONCAT("อ.",users.fname_th," ", users.lname_th) AS creater'))
            ->orderBy('fname_th','ASC')
            ->orderBy('section_name','ASC')
            ->get();
//            ->select('sections.*', 'users.prefix', 'users.fname_th' , 'users.lname_th')
//        $findAllSection = Section::all()->orderBy('section_name');
        return response()->json($sections);
    }

    public function findMySection(Request $request)
    {
        $sections = DB::table('sections')
            ->join('users', 'sections.user_id', '=', 'users.id')
            ->select('sections.*', DB::raw('CONCAT("อ.",users.fname_th," ", users.lname_th) AS creater'))
            ->where('user_id',$request->id)
            ->orderBy('section_name','ASC')
            ->get();
//        ->select('sections.*', 'users.prefix', 'users.fname_th' , 'users.lname_th')
//        $findMySection = Section::where('user_id',$request->id)
//        ->orderBy('section_name')->get();
        return response()->json($sections);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $findSectionName = Section::where('section_name', $request->section_name)
            ->where('user_id',$request->user_id)
            ->first();
        if ($findSectionName === NULL) {
            $section = new Section();
            $section->user_id = $request->user_id;
            $section->section_name = $request->section_name;
            $section->save();
        } else {
            return response()->json(['error' => 'Error msg'], 209);
        }

    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $findSectionName = Section::where('section_name', $request->section_name)
            ->where('user_id', $request->user_id)
            ->first();

        if ($findSectionName === NULL) {
            $section = Section::find($request->id);
            $section->section_name = $request->section_name;
            $section->save();
        } else {
            if($findSectionName->id == $request->id){
                $section = Section::find($request->id);
                $section->section_name = $request->section_name;
                $section->save();
            }else {
                return response()->json(['error' => 'Error msg'], 209);
            }

        }
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        $section = Section::find($request->id);
        $user = Users::find($section->user_id);
        $userFolder = $user->id."_".$user->fname_en."_".$user->lname_en;
        $sectionFolder = "Section_".$section->id;
        $this->rrmdir("../upload/exam/".$userFolder."/".$sectionFolder);
        $section->delete();
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

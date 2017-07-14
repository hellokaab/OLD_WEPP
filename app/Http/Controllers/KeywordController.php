<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keyword;

class KeywordController extends Controller
{
    public function index()
    {
        //
    }


    public function findKeywordByEID(Request $request)
    {
        $keyword = Keyword::where('exam_id',$request->exam_id)->get();
        return response()->json($keyword);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $keyword = new Keyword;
        $keyword->exam_id = $request->exam_id;
        $keyword->keyword_data = $request->keyword;
        $keyword->save();
        return response()->json($request->keyword);
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $keyword = Keyword::find($request->id);
        $keyword->keyword_data = $request->keyword_data;
        $keyword->save();
    }


    public function destroy(Request $request)
    {
        $keyword = Keyword::find($request->id);
        $keyword->delete();
    }
}

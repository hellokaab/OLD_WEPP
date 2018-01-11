<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Examing;
use App\ResExam;
use App\Section;
use App\Sheeting;
use App\WorksheetGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Users;
use Illuminate\Support\Facades\Session;
use Psy\Util\Str;
use DirectoryIterator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $findUser = Users::where('personal_id', $request->personalId)->first();
        if ($findUser === NULL) {
            $users = new Users;
            $users->personal_id = $request->personalId;
            $users->prefix = $request->prename;
            $users->fname_en = $request->cn;
            $users->fname_th = $request->firstNameThai;
            $users->lname_en = $request->sn;
            $users->lname_th = $request->lastNameThai;
            $users->stu_id = $request->studentId;
            $users->faculty = $request->faculty;
            $users->department = $request->program;
            $users->email = $request->mail;
            if($request->gidNumber == "4500"){
                $users->user_type = 's';
            }elseif ($request->gidNumber == "2800"){
                $users->user_type = 't';
            }else{
                $users->user_type = 'o';
            }
            $users->save();
            return response()->json($users);
        }else{
            $users = Users::find($findUser->id);
            $users->personal_id = $request->personalId;
            $users->prefix = $request->prename;
            $users->fname_en = $request->cn;
            $users->fname_th = $request->firstNameThai;
            $users->lname_en = $request->sn;
            $users->lname_th = $request->lastNameThai;
            $users->stu_id = $request->studentId;
            $users->faculty = $request->faculty;
            $users->department = $request->program;
            $users->email = $request->mail;
            if($request->gidNumber == "4500"){
                $users->user_type = 's';
            }elseif ($request->gidNumber == "2800"){
                $users->user_type = 't';
            }else{
                $users->user_type = 'o';
            } $users->save();
            return response()->json($users);
//            return response()->json("Happy");
        }
    }

    public function findByPersonalID(Request $request){
        $findUser = Users::where('personal_id', $request->personalId)->first();
        return $findUser;
    }

    public function findCreaterByPersonalID($PID){
        $findUser = Users::where('personal_id', $PID)->first();
        return $findUser;
    }

    public function findTeacher(){
        $findTeacher = DB::table('users')
            ->select('users.*', DB::raw('CONCAT("อ.",users.fname_th," ", users.lname_th) AS fullname'))
            ->where('user_type','t')
            ->orderBy('fname_th','ASC')
            ->get();
        return response()->json($findTeacher);
    }

    public function findUserByID(Request $request){
        $findUser = Users::find($request->id);
        return response()->json($findUser);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function findAdmin(Request $request)
    {
        $admin = Admin::where('username',$request->username)
            ->where('password',$request->password)
            ->first();
        if ($admin === NULL) {
             return response()->json(['error' => 'Error msg'], 209);
        }else{
            Session::set('wepp_admin',$admin);
        }
    }

    public function getAdmin()
    {
        $admin = Session::get('wepp_admin');
        return response()->json($admin);
    }

    public function teaList()
    {
//        $data = array(
//            'admin' => Session::get('wepp_admin')
//        );

        return view('pages/admin/teaList');
    }

    public function stdList()
    {
        return view('pages/admin/stdList');
    }

    public function findAllTeacher(){
        $teacher = Users::where('user_type','t')
            ->orderBy('fname_th', 'asc')
            ->orderBy('lname_th', 'asc')
            ->get();
        return response()->json($teacher);
    }

    public function findAllStudent(){
        $student = Users::where('user_type','s')
            ->orderBy('stu_id', 'asc')
            ->get();
        return response()->json($student);
    }

    public function deleteTeacher(Request $request){
        $user = Users::find($request->user_id);
        $userFolder = $user->id."_".$user->fname_en."_".$user->lname_en;
        $this->rrmdir("../upload/exam/".$userFolder);
        $this->rrmdir("../upload/worksheet/".$userFolder);

        $examings = Examing::where('user_id',$request->user_id)->get();
        foreach ($examings as $examing) {
            $examingFolder = "Examing_".$examing->id;
            $this->rrmdir("../upload/resexam/".$examingFolder);
        }

        $sheetings = Sheeting::where('user_id',$request->user_id)->get();
        foreach ($sheetings as $sheeting) {
            $sheetingFolder = "Sheeting_".$sheeting->id;
            $this->rrmdir("../upload/resworksheet/".$sheetingFolder);
        }
        $user->delete();
    }

    public function deleteStudent(Request $request){
        $user = Users::find($request->user_id);
        $userFolder = $user->stu_id."_".$user->fname_en."_".$user->lname_en;

        $result_exams = ResExam::where('user_id',$request->user_id)->get();
        foreach ($result_exams as $result_exam) {
            $this->rrmdir("../upload/resexam/Examing_".$result_exam->examing_id
                ."/Exam_".$result_exam->exam_id."/".$userFolder);
        }
        $user->delete();
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

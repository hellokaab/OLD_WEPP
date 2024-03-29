@extends('layouts.template')
@section('content')
    <script src="js/Components/student/assistSheetBoardCtrl.js"></script>
    <script>
        var sheetingID = {{$sheetingID}};
    </script>
    <div ng-controller="assistSheetBoardCtrl" style="display: none" id="sheet_board_div">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/index')}}">หน้าหลัก</a></li>
                <li>กลุ่มเรียน</li>
                <li><a href="{{ url('/stdMyGroup')}}">กลุ่มเรียนของฉัน</a></li>
                <li><a href="{{ url('/inGroup<%sheeting.group_id%>')}}"><%group.group_name%> (<%group.creater%>)</a></li>
                <li><%sheeting.sheeting_name%></li>
                <li class="active">สรุปผลคะแนนใบงาน</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <b style="color: #555">สรุปผลคะแนนใบงาน</b>
                </div>
                <div class="panel-body">
                    <div class="text-center">
                        <h3 id="sheet_title"><%sheeting.sheeting_name%>  (กลุ่มเรียน: <%group.group_name%>)</h3>
                    </div>
                    <div class="form-horizontal" role="form">
                        <div class="form-group" style="padding-top: 10px">
                            <label class="col-md-4 control-label">ใบงาน </label>
                            <div class="col-md-4">
                                <select class="form-control" id="select_sheet_id">
                                    <option style="display: none"></option>
                                    <option ng-repeat="ss in sheetSheeting" value="<%ss.sheet_id%>"><%ss.sheet_name%></option>
                                </select>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-xs-12" style="text-align: center">
                            <div class="form-group">
                                <label class="col-md-1 col-xs-2 control-label"
                                       style="margin-top: 14px;padding-right: 0px">ค้นหา</label>
                                <div class="col-md-4 col-xs-10" style="padding-right: 0px;padding-top: 7px">
                                    <input type="text" id="txt_search" class="form-control" ng-model="search"
                                           placeholder="ชื่อนักศึกษา">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div id="table_part">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสนักศึกษา</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th style="text-align: center">คะแนนการทดลอง</th>
                                <th style="text-align: center">คะแนนคำถาม</th>
                                <th style="text-align: center;width: 10%">หมายเหตุ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="d in dataInSheetBoard|filter:search">
                                <td><%$index+1%></td>
                                <td><%d.stu_id%></td>
                                <td><%d.full_name%></td>
                                <td  style="text-align: center">
                                    <b ng-show="d.score != null"><a href="#" ng-click="viewResSheet(d)"><%d.score%></a>  / <%thisSheet.full_score%></b>
                                </td>
                                <td style="text-align: center">
                                    <b ng-show="d.sum_score_quiz != null"><a href="#" ng-click="viewResSheet(d)"><%d.sum_score_quiz%></a>  / <%sumScoreQuiz%></b>
                                </td>
                                <td style="text-align: center;color: red">
                                    <b ng-show="d.send_late == 1">ส่งล่าช้า</b>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ResSheet Modal -->
        <div class="modal fade" id="res_sheet_modal" role="dialog">
            <div class="modal-dialog" style="width: 95%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="panel panel-purple" id="res_sheet_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title">ใบงาน</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <h4>ข้อมูลผู้ส่ง</h4>
                                    <div class="form-group">
                                        <div class="col-md-5">
                                            <b>ชื่อ : </b><x id="stdName"></x>
                                        </div>
                                        <div class="col-md-5">
                                            <b>รหัสนักศึกษา : </b><x id="stdCode"></x>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-5">
                                            <b>กลุ่มเรียน : </b><x><%group.group_name%></x>
                                        </div>
                                        <div class="col-md-4">
                                            <b>การสั่งงาน : </b><x><%sheeting.sheeting_name%></x>
                                        </div>
                                        <div class="col-md-4">
                                            <b>ใบงาน : </b><a id="sheetName" href="#" ng-click="viewSheet()"><%thisSheet.sheet_name%></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>โค้ดที่ส่ง</h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-7" style="padding-top: 10px">
                                        <b>สถานะการส่งคำตอบ : </b><b id="status_sheet">ผ่าน</b>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-horizontal" role="form">
                                            <div class="form-group" style="margin-bottom: 0">
                                                {{--<div class="col-md-1"></div>--}}
                                                <label class="col-md-4 control-label" style="padding-right: 0">คะแนนการทดลองที่ได้ : </label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" id="std_score" ng-model="stdScore" style="text-align: right" disabled="disabled">
                                                </div>
                                                <label class="col-md-1 control-label" style="text-align: left;padding-left: 0" id="full_score_trial">/ <%thisSheet.full_score%></label>
                                                <div class="col-md-4">
                                                    <button type="button" id="btn_edit_trial_score" class="btn btn-outline-warning" ng-hide="changeScore" ng-click="editTrialScore()">แก้ไข</button>
                                                    <button type="button" class="btn btn-outline-success" ng-show="changeScore" ng-click="okEditTrialScore()">บันทึก</button>
                                                    <button type="button" class="btn btn-outline-danger" ng-show="changeScore" ng-click="cancelEditTrialScore()">ยกเลิก</button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <div class="notice" id="notice_std_score" style="display: none">กรุณาระบุชื่อข้อสอบ</div>
                                                    <div id="success_std_score" style="display: none;text-align: left;color: green;padding: 3px 0 3px 5px;">กรุณาระบุชื่อข้อสอบ</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6"><b>โค้ดที่ส่ง: </b>
                                        {{--tag mycode สร้างขึ้นมาเอง อยู่ในไฟล์ myCustom.css--}}
                                        <mycode id="std_code" class="pre-scrollable" style="height: 470px;max-height: 510px;"></mycode>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12"><b>ผลการรันที่ใช้ทดสอบ: </b>
                                                <mycode id="tea_output" class="nohighlight hljs pre-scrollable" style="height: 220px"></mycode>
                                            </div>
                                            <div class="col-md-12"><b>ผลการรันของนักศึกษา: </b>
                                                <mycode id="resrun" class="nohighlight hljs pre-scrollable" style="height: 220px"></mycode>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row" ng-show="quizThisSheet.length > 0">
                                <div class="col-md-12">
                                    <h4>คำถามท้ายการทดลอง</h4>
                                </div>
                                <br>
                                <div class="form-horizontal" role="form" ng-repeat="q in quizThisSheet">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">ข้อที่ <%$index+1%> :</label>
                                        <label class="col-md-8 control-label" style="text-align: left"><b><%q.quiz_data%> (<%q.quiz_score%> คะแนน)</b></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">เฉลย :</label>
                                        <label class="col-md-6 control-label" style="text-align: left"><b><%q.quiz_ans%></b></label>
                                        <label class="col-md-4 control-label" style="text-align: left"><b>คะแนนที่ได้</b></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">ตอบ :</label>
                                        <div class="col-md-6">
                                            <textarea id="quizAns_<%q.id%>" class="form-control io_textarea pre-scrollable" rows="3" disabled style="background-color: white"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="quiz_score_<%q.id%>"  style="text-align: right" disabled="disabled">
                                                </div>
                                                <label class="col-md-1 control-label" style="text-align: left;padding-left: 0" id="full_score_quiz_<%q.id%>">/ <%q.quiz_score%></label>
                                                <div class="col-md-7">
                                                    <button type="button" id="edit_quiz_<%q.id%>" ng-click="editScoreQuiz(q.id)" class="btn btn-outline-warning">แก้ไข</button>
                                                    <button type="button" id="save_quiz_<%q.id%>" ng-click="saveScoreQuiz(q.id)" class="btn btn-outline-success" style="display: none">บันทึก</button>
                                                    <button type="button" id="cancel_quiz_<%q.id%>" ng-click="cancelScoreQuiz(q.id)" class="btn btn-outline-danger" style="display: none">ยกเลิก</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="notice" id="notice_quiz_score_<%q.id%>" style="display: none">กรุณาระบุชื่อข้อสอบ</div>
                                                    <div id="success_quiz_score_<%q.id%>" style="display: none;text-align: left;color: green;padding: 3px 0 3px 5px;">กรุณาระบุชื่อข้อสอบ</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Model footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-purple" data-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fail Modal -->
        <div id="fail_modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-danger" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title">ข้อผิดพลาด</h3>
                        </div>
                        <div style="padding-top: 7%; text-align: center" id="err_message">รหัสผ่านเข้าสอบไม่ถูกต้อง</div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#sheet_board_div').css('display', 'block');
        });
    </script>
@endsection
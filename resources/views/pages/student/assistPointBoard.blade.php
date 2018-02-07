@extends('layouts.template')
@section('content')
    <script src="js/Components/student/assistPointBoardCtrl.js"></script>
    <script>
        var examingID = {{$examingID}};
    </script>
    <div ng-controller="assistPointBoardCtrl" style="display: none" id="point_board_div">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/index')}}">หน้าหลัก</a></li>
                <li>กลุ่มเรียน</li>
                <li><a href="{{ url('/stdMyGroup')}}">กลุ่มเรียนของฉัน</a></li>
                <li><a href="{{ url('/inGroup<%examing.group_id%>')}}"><%group.group_name%> (<%group.creater%>)</a></li>
                <li><%examing.examing_name%></li>
                <li class="active">สรุปผลคะแนนสอบ</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <b style="color: #555">สรุปผลคะแนนสอบ</b>
                </div>
                <div class="panel-body">
                    <div class="text-center">
                        <h3 id="examing_title"><%examing.examing_name%> (กลุ่มเรียน: <%group.group_name%>)</h3>
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
                    <table class="table table-hover table-striped">
                        {{--<thead id="score_board_hd"></thead>--}}
                        {{--<tbody id="score_board_tb"></tbody>--}}
                        <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัสนักศึกษา</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th ng-repeat="eem in examExaming" style="text-align: center"><%eem.exam_name%></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="pb in pointBoard|filter:search">
                            <td><%$index+1%></td>
                            <td><%pb.stu_id%></td>
                            <td><%pb.full_name%></td>
                            <td ng-repeat="res in pb.res_status" style="text-align: center">
                                <b ng-show="res.length > 0"><a href="#" ng-click="viewResExamHistory(res[0])"><%res[0].score%></a> / <%scoreExams[$index]%></b>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ResExam Modal -->
        <div class="modal fade" id="resExam_modal" role="dialog">
            <div class="modal-dialog" style="width: 95%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="panel panel-purple" id="resExam_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title">ประวัติการส่งข้อสอบ</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <h4>ข้อมูลผู้สอบ</h4>
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
                                            <b>การสอบ : </b><x><%examing.examing_name%></x>
                                        </div>
                                        <div class="col-md-4">
                                            <b>ข้อสอบ : </b><a id="examName" href="#" ng-click="viewExam()"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <h4 style="visibility: hidden">Test</h4>
                                    <div class="form-horizontal" role="form">
                                        <div class="form-group" style="margin-bottom: 0">
                                            <div class="col-md-1"></div>
                                            <label class="col-md-3 control-label" style="padding-right: 0">คะแนนที่ได้ : </label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" id="std_score" ng-model="stdScore" style="text-align: right" disabled="disabled">
                                            </div>
                                            <label class="col-md-1 control-label" style="text-align: left;padding-left: 0" id="full_score_exam"></label>
                                            <div class="col-md-4">
                                                <button type="button" id="btn_edit_score" class="btn btn-outline-warning" ng-hide="changeScore" ng-click="editScore()">แก้ไข</button>
                                                <button type="button" class="btn btn-outline-success" ng-show="changeScore" ng-click="okEdit()">บันทึก</button>
                                                <button type="button" class="btn btn-outline-danger" ng-show="changeScore" ng-click="cancleEdit()">ยกเลิก</button>
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
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>ประวัติการส่งข้อสอบ</h4>
                                    <div class="col-md-12">
                                        <ul class="nav nav-tabs" id="tab_test">
                                            {{--<li class="active"><a id="li_a" style="background-color: #8CC152;font-weight: 700" data-toggle="tab" href="">คำตอบถูกต้อง (<%resexam.sum_accep%> ครั้ง)</a></li>--}}
                                            {{--<li><a id="li_i" style="font-weight: 700" data-toggle="tab" href="">ถูกต้องบางส่วน (<%resexam.sum_imp%> ครั้ง)</a></li>--}}
                                            {{--<li><a id="li_w" style="font-weight: 700" data-toggle="tab" href="">คำตอบผิด (<%resexam.sum_wrong%> ครั้ง)</a></li>--}}
                                            {{--<li><a id="li_c" style="font-weight: 700" data-toggle="tab" href="">คอมไพล์ผิดพลาด (<%resexam.sum_comerror%> ครั้ง)</a></li>--}}
                                            {{--<li><a id="li_t" style="font-weight: 700" data-toggle="tab" href="">เวลาเกินกำหนด (<%resexam.sum_overtime%> ครั้ง)</a></li>--}}
                                            {{--<li><a id="li_m" style="font-weight: 700" data-toggle="tab" href="">หน่วยความจำเกินกำหนด (<%resexam.sum_overmem%> ครั้ง)</a></li>--}}
                                            <li class="active"><a id="li_a" style="background-color: #8CC152;font-weight: 700" data-toggle="tab" href="" ng-click="changeTab('a')">Accept (<%resexam.sum_accep%>)</a></li>
                                            <li><a id="li_i" style="font-weight: 700" data-toggle="tab" href="" ng-click="changeTab('i')">Imperfect (<%resexam.sum_imp%>)</a></li>
                                            <li><a id="li_w" style="font-weight: 700" data-toggle="tab" href="" ng-click="changeTab('w')">Wrong answer (<%resexam.sum_wrong%>)</a></li>
                                            <li><a id="li_c" style="font-weight: 700" data-toggle="tab" href="" ng-click="changeTab('c')">Compile error (<%resexam.sum_comerror%>)</a></li>
                                            <li><a id="li_t" style="font-weight: 700" data-toggle="tab" href="" ng-click="changeTab('t')">Over runtime (<%resexam.sum_overtime%>)</a></li>
                                            <li><a id="li_m" style="font-weight: 700" data-toggle="tab" href="" ng-click="changeTab('m')">Over memory (<%resexam.sum_overmem%>)</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="res_history" class="tab-pane fade in active">
                                                <br>
                                                <div class="col-md-12" ng-repeat="p in pathExam" ng-show="checkTab(p)">
                                                    <div class="row" id="res_list_<%p.id%>" style="margin-bottom: 10px">
                                                        <div class="col-md-3"><b>ส่งครั้งที่: </b> <%$index + 1%> </div>
                                                        <div class="col-md-3"><b>สถานะ: </b> <%(p.status === 'q') ? 'ค้างคิวตรวจ' :
                                                            (p.status === 'a') ? 'ผ่าน' :
                                                            (p.status === 'w') ? 'คำตอบผิด' :
                                                            (p.status === 'm') ? 'ความจำเกินกำหนด' :
                                                            (p.status === 't') ? 'เวลาเกินกำหนด' :
                                                            (p.status === 'c') ? 'คอมไพล์ไม่ผ่าน' :
                                                            (p.status === '9') ? 'PPPPP-' :
                                                            (p.status === '8') ? 'PPPP--' :
                                                            (p.status === '7') ? 'PPP---' :
                                                            (p.status === '6') ? 'PP----' :
                                                            (p.status === '5') ? 'P-----' : 'ไม่ทราบสถานะ'%>
                                                        </div>
                                                        <div class="col-md-3"><b>เวลาส่ง: </b> <% p.send_date_time%> </div>
                                                        <div class="col-md-3"><a href="#res_list_<%p.id%>" ng-click="viewCode(p)">รายละเอียด <span class="caret"></span></a></div>
                                                    </div>
                                                    <div class="row" id="detail_<%p.id%>" style="display: none;">
                                                        <div style="margin-bottom: 10px">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-3"><b>เวลาที่ใช้: </b> <% p.time == null  ? '-' : p.time %> วินาที</div>
                                                            <div class="col-md-3"><b>หน่วยความจำที่ใช้: </b> <% p.memory == null ? '-' : p.memory %> KB</div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6"><b>โค้ดที่ส่ง: </b>
                                                                    {{--tag mycode สร้างขึ้นมาเอง อยู่ในไฟล์ myCustom.css--}}
                                                                    <mycode id="code_<%p.id%>" class="pre-scrollable" style="height: 510px;max-height: 510px;"></mycode>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-12"><b>ผลการรันที่ใช้ทดสอบ: </b>
                                                                            <mycode id="tea_output_<%p.id%>" class="nohighlight hljs pre-scrollable" style="height: 240px"></mycode>
                                                                        </div>
                                                                        <div class="col-md-12"><b>ผลการรันของนักศึกษา: </b>
                                                                            <mycode id="resrun_<%p.id%>" class="nohighlight hljs pre-scrollable" style="height: 240px"></mycode>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Model footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-purple" data-dismiss="modal" ng-click="cancleEdit()">ปิด</button>
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
            $('#point_board_div').css('display', 'block');
        });

        $('[id^=li_]').on('click',function () {
            $('[id^=li_]').each(function () {
                $(this).css("background-color", "");
            });
            var status = (this.id).split('_')[1];
            if(status === 'a'){
                $(this).css("background-color", "#8CC152");
            }else if(status === 'i'){
                $(this).css("background-color", "#F6BB42");
            }else if(status === 'w'){
                $(this).css("background-color", "#DA4453");
            }else if(status === 'c'){
                $(this).css("background-color", "#AAB2BD");
            }else if(status === 't'){
                $(this).css("background-color", "#3BAFDA");
            }else if(status === 'm'){
                $(this).css("background-color", "#D770AD");
            }
        })
    </script>
@endsection
@extends('layouts.template')
@section('content')
    <script src="js/Components/teacher/teaInGroupCtrl.js"></script>
    <script>
        var groupId = {{$groupID}};
        var groupData = findGroupDataByID(groupId);
    </script>
    <div ng-controller="teaInGroupCtrl" style="display: none" id="tea_in_group_div">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="<%myUrl%>/index">หน้าหลัก</a></li>
                <li><a href="<%myUrl%>/group">กลุ่มเรียน</a></li>
                <li class="active"><%groupData.group_name%></li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default ">
                <div class="panel-heading" style="height: 54px"><label style="font-size: 20px;color: #337ab7;padding-top: 5px"><%groupData.group_name%></label>
                    <button class="btn btn-outline-warning" href="" ng-click="editGroup()" style="float: right"><i class="fa fa-pencil-square-o"> </i> แก้ไขกลุ่ม</button>
                </div>
                <div class="panel-body">
                    <br>
                    <div class="col-lg-12" style="padding: 0px">
                        <label style="text-decoration:underline;font-size: 18px;padding-top: 5px">การสอบ</label><button class="btn btn-sm btn-outline-success" href="" ng-click="openExaming()" style="float: right"><i class="fa fa-plus"> </i> เปิดสอบ</button>
                    </div>
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="width: 20%">ชื่อการสอบ</th>
                            <th style="width: 20%;text-align: center">เริ่มต้น</th>
                            <th style="width: 20%;text-align: center">สิ้นสุด</th>
                            <th style="width: 23%;text-align: center">ซ่อน/แสดง</th>
                            <th style="width: 17%;text-align: center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="e in examingComing" ng-show="examingComing.length > 0">
                            <td><%e.examing_name%></td>
                            <td style="text-align: center"><%e.start_date_time%></td>
                            <td style="text-align: center"><%e.end_date_time%></td>
                            <td>
                                <div class="radio inline-form-control">
                                    <div class="col-md-6" style="text-align: center">
                                        <input type="radio" name="hide_examing_<%e.id%>" id="hide_ex_<%e.id%>" value="0" ng-click="changeToHidden(e)">
                                        <label for="hide_ex_<%e.id%>" style="padding-left: 2px">ซ่อน</label>
                                    </div>
                                    <div class="col-md-6" style="text-align: center">
                                        <input type="radio" name="hide_examing_<%e.id%>" id="show_ex_<%e.id%>" value="1" ng-click="changeToShow(e)">
                                        <label for="show_ex_<%e.id%>" style="padding-left: 2px">แสดง</label>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center">
                                <button class="btn btn-sm btn-outline-warning" title="แก้ไข" style="cursor:pointer" ng-click="editExaming(e)">
                                    <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                                </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-sm btn-outline-purple" title="score board" style="cursor:pointer" ng-click="viewScore(e)">
                                    <i class="fa fa-trophy fa-lg" aria-hidden="true"></i>
                                </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-sm btn-outline-danger" title="ลบ" style="cursor:pointer" ng-click="deleteExaming(e)">
                                    <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <tr ng-hide="examingComing.length > 0">
                            <td>ไม่พบข้อมูล</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <div class="col-lg-12" style="padding: 0px">
                        <label style="text-decoration:underline;font-size: 18px;padding-top: 5px">ประวัติการเปิดสอบ</label>
                    </div>
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="width: 20%">ชื่อการสอบ</th>
                            <th style="width: 20%;text-align: center">เริ่มต้น</th>
                            <th style="width: 20%;text-align: center">สิ้นสุด</th>
                            <th style="width: 23%;text-align: center">การเข้าถึงประวัติการสอบ</th>
                            <th style="width: 17%;text-align: center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="e in examingEnding" ng-show="examingEnding.length > 0">
                            <td><%e.examing_name%></td>
                            <td style="text-align: center"><%e.start_date_time%></td>
                            <td style="text-align: center"><%e.end_date_time%></td>
                            <td>
                                <div class="radio inline-form-control">
                                    <div class="col-md-6" style="text-align: center">
                                        <input type="radio" name="hide_history_<%e.id%>" id="hide_hi_<%e.id%>" value="0" ng-click="changeToAllow(e)">
                                        <label for="hide_hi" style="padding-left: 2px">อนุญาต</label>
                                    </div>
                                    <div class="col-md-6" style="text-align: center">
                                        <input type="radio" name="hide_history_<%e.id%>" id="show_hi_<%e.id%>" value="1" ng-click="changeToDisallow(e)">
                                        <label for="show_hi" style="padding-left: 2px">ไม่อนุญาต</label>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center">
                                <button class="btn btn-sm btn-outline-warning" title="แก้ไข" style="cursor:pointer" ng-click="editExaming(e)">
                                    <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                                </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-sm btn-outline-danger" title="ลบ" style="cursor:pointer" ng-click="deleteExaming(e)">
                                    <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <tr ng-hide="examingEnding.length > 0">
                            <td>ไม่พบข้อมูล</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{--Student List --}}
        <div class="col-lg-12">
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <b>รายชื่อสมาชิก</b>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-offset-8 col-md-4 col-xs-12" style="text-align: center">
                            <label class="col-md-offset-4 col-md-2 col-xs-2 control-label" style="margin-top: 14px">แสดง</label>
                            <div class="col-md-4 col-xs-8" style="padding-right: 0px;padding-top: 7px">
                                <select class="form-control" ng-model="selectRow">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <label class="col-md-2 col-xs-2 control-label" style="margin-top: 14px">แถว</label>
                        </div>
                    </div>
                    <br>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>รหัสนักศึกษา</th>
                            <th>ชื่อ - นามสกุล</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-show="memberList.length > 0" dir-paginate="m in memberList|orderBy:stu_id|itemsPerPage:selectRow">
                            <td><%m.stu_id%></td>
                            <td><%m.fullName%></td>
                            <td style="text-align: center">
                                <button class="btn btn-sm btn-outline-primary" title="รายละเอียด" style="cursor:pointer" ng-click="showProfile(m)">
                                    <i class="fa fa-address-card fa-lg" aria-hidden="true"></i>
                                </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-sm btn-outline-danger" title="ลบ" style="cursor:pointer" ng-click="deleteMember(m)">
                                    <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <tr ng-hide="memberList.length > 0">
                            <td>ไม่พบรายชื่อสมาชิก</td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <dir-pagination-controls
                            max-size="5"
                            direction-links="true"
                            boundary-links="true" >
                    </dir-pagination-controls>
                </div>
            </div>
        </div>

        <!-- Edit Group Modal -->
        <div class="modal fade" id="edit_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-warning" id="editGroupPart" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #fff">แก้ไขกลุ่มเรียน</h3>
                        </div>
                        <div class="form-horizontal" role="form" style="padding-top: 7%">
                            <label class="col-md-4 control-label">ชื่อกลุ่มเรียน</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="groupName"
                                           ng-keyup="$event.keyCode === 13 && enterEdit()" maxlength="200"/>
                                    <div class="notice" id="notice_name_edit_grp" style="display: none">
                                        กรุณาระบุชื่อกลุ่มเรียน
                                    </div>
                                </div>
                            </div>
                            <label class="col-md-4 control-label">รหัสเข้ากลุ่ม</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="passwordGroup"
                                           ng-keyup="$event.keyCode === 13 && enterOkEdit()" maxlength="8"
                                           placeholder="อย่างน้อย 4 ตัวอักษร"/>
                                    <div class="notice" id="notice_pass_edit_grp" style="display: none">
                                        กรุณาระบุรหัสเข้ากลุ่ม
                                    </div>
                                </div>
                            </div>
                            <!-- un use -->
                            <div class="form-group"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-warning" ng-click="okEditGroup()">ตกลง</button>
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Examing Modal -->
        <div class="modal fade" id="delete_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-danger" id="deleteExamingPart" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title">ยืนยันการทำรายการ</h3>
                        </div>
                        <div style="padding-top: 7%; text-align: center">คุณต้องการลบการสอบนี้หรือไม่</div>
                        <br>
                        <input ng-model="examingName" value="" style="margin-left: 10%; width: 80%" type="text" class="form-control text-center"  disabled/>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" ng-click="okDeleteExaming()">ตกลง</button>
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Member Modal -->
        <div class="modal fade" id="delete_member_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-danger" id="delete_member_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title">ยืนยันการทำรายการ</h3>
                        </div>
                        <div style="padding-top: 7%; text-align: center">คุณต้องการลบสมาชิกคนนี้ออกจากกลุ่มหรือไม่</div>
                        <br>
                        <input ng-model="memberName" value="" style="margin-left: 10%; width: 80%" type="text" class="form-control text-center"  disabled/>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" ng-click="okDeleteMember()">ตกลง</button>
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden Modal -->
        <div class="modal fade" id="change_hidden_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-info" id="change_hidden_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #555">ยืนยันการทำรายการ</h3>
                        </div>
                        <div style="padding-top: 7%; text-align: center">คุณต้องการซ่อนการสอบนี้หรือไม่</div>
                        <br>
                        <input style="margin-left: 10%; width: 80%" type="text" class="form-control text-center"
                               ng-model="examingName" disabled/>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-info" ng-click="okHidden()">ตกลง</button>
                            <button type="button" class="btn btn-outline-default" ng-click="cancelHidden()">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Show Modal -->
        <div class="modal fade" id="change_show_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-info" id="change_show_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #555">ยืนยันการทำรายการ</h3>
                        </div>
                        <div style="padding-top: 7%; text-align: center">คุณต้องการแสดงการสอบนี้หรือไม่</div>
                        <br>
                        <input style="margin-left: 10%; width: 80%" type="text" class="form-control text-center"
                               ng-model="examingName" disabled/>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-info" ng-click="okShow()">ตกลง</button>
                            <button type="button" class="btn btn-outline-default" ng-click="cancelShow()">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Allow Modal -->
        <div class="modal fade" id="change_allow_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-info" id="change_allow_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #555">ยืนยันการทำรายการ</h3>
                        </div>
                        <div style="padding-top: 7%; text-align: center">คุณต้องการเปลี่ยนแปลงการเข้าถึงประวัติการสอบนี้</div>
                        <br>
                        <input style="margin-left: 10%; width: 80%" type="text" class="form-control text-center"
                               ng-model="examingName" disabled/>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-info" ng-click="okAllow()">ตกลง</button>
                            <button type="button" class="btn btn-outline-default" ng-click="cancelAllow()">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disallow Modal -->
        <div class="modal fade" id="change_disallow_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-info" id="change_disallow_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #555">ยืนยันการทำรายการ</h3>
                        </div>
                        <div style="padding-top: 7%; text-align: center">คุณต้องการเปลี่ยนแปลงการเข้าถึงประวัติการสอบนี้</div>
                        <br>
                        <input style="margin-left: 10%; width: 80%" type="text" class="form-control text-center"
                               ng-model="examingName" disabled/>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-info" ng-click="okDisallow()">ตกลง</button>
                            <button type="button" class="btn btn-outline-default" ng-click="cancelDisallow()">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Modal -->
        <div class="modal fade" id="detail_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-info" id="detail_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color:#555">ข้อมูลส่วนตัว</h3>
                        </div>
                        <div class="form-horizontal" role="form" style="padding-top: 7%">
                            <label class="col-md-4 control-label">คำนำหน้า</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="prefix" disabled/>
                                </div>
                            </div>
                            <label class="col-md-4 control-label">ชื่อ-นามสกุล</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="name" disabled/>
                                </div>
                            </div>
                            <label class="col-md-4 control-label">อีเมล</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="email" disabled/>
                                </div>
                            </div>
                            <label class="col-md-4 control-label">รหัสประจำตัวนักศึกษา</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="cardId" disabled/>
                                </div>
                            </div>
                            <label class="col-md-4 control-label">คณะ</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="faculty" disabled/>
                                </div>
                            </div>
                            <label class="col-md-4 control-label">สาขา</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="department" disabled/>
                                </div>
                            </div>
                            <!-- un use -->
                            <div class="form-group"></div>
                        </div>
                        <!-- Model footer -->
                        <div class="modal-footer">
                            <button class="btn btn-outline-info" data-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Score Board Modal -->
        <div class="modal fade" id="score_modal" role="dialog">
            <div class="modal-dialog" style="width: 95%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="panel panel-purple" id="score_part" style="margin-bottom: 0">
                        <!-- Panel header -->
                        <div class="panel-heading">
                            <h3 class="panel-title">Score board</h3>
                        </div>
                        <!-- Form -->
                        <div class="text-center">
                            <h3 id="examing_title"><%examing.examing_name%></h3>
                        </div>
                        <br>
                        <div style="margin-right: 3%; margin-left: 3%;">
                            <table class="table table-hover table-striped">
                                <thead id="score_board_hd"></thead>
                                <tbody id="score_board_tb"></tbody>
                            </table>
                        </div>
                        <br>
                        <!-- Model footer -->
                        <div class="modal-footer">
                            <div class="text-left hidden-print hidden-xs hidden-sm" style="margin-left: 2%">
                                <b>หมายเหตุ:</b>
                                <i>
                                    <x class="accpet">Accept</x> /
                                    <x class="imperfect">Imperfect</x> /
                                    <x class="wrong_ans">Wrong answer</x> /
                                    <x class="complie_err">Compile error</x> /
                                    <x class="over_time">Over runtime</x> /
                                    <x class="over_mem">Over memory</x>
                                </i>
                            </div>
                            <button type="button" class="btn btn-outline-purple" data-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Exam Modal -->
        <div class="modal fade" id="detail_exam_modal" role="dialog">
            <div class="modal-dialog" style="width: 98%; padding-right: 12px">
                <div class="modal-content">
                    <div class="panel panel-primary" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #fff">รายละเอียดข้อสอบ</h3>
                        </div>
                        <div class="panel-body">

                            <h4 class="text-center" id="examName"></h4>
                            <br>
                            <div class="col-md-3"><b>Time limit:</b> <span id="examTimeLimit"></span> Seconds</div>
                            <div class="col-md-3"><b>Memory limit:</b> <span id="examMemLimit"></span> KB</div>
                            <div class="col-md-12">
                                <br>
                                <b>โจทย์:</b>
                                <div id="exam_content"></div>
                            </div>


                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <br>
                                        <b>อินพุท:</b>
                                        <div id="input_part">
                                            <textarea class="form-control code_textarea" style="background-color: #fff"
                                                      id="examInput" rows="10" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <b>เอาท์พุท:</b>
                                        <div id="output_part">
                                            <textarea class="form-control code_textarea" style="background-color: #fff"
                                                      id="examOutput" rows="10" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <b>เกณฑ์การให้คะแนน:</b>
                                                <div class="list-group">
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="fullScore">100</span>
                                                        - คะแนนเต็ม
                                                    </a>
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="imperfect">50</span>
                                                        - คำตอบถูกต้องบางส่วน (% ของคะแนนเต็ม)
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <b>เกณฑ์การหักคะแนน:</b>
                                                <div class="list-group">
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="cutWrongAnswer">10</span>
                                                        - คำตอบผิดพลาด
                                                    </a>
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="cutComplieError">10</span>
                                                        - รูปแบบโค้ดไม่ถูกต้อง
                                                    </a>
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="cutOverMem">10</span>
                                                        - หน่วยความจำเกิน
                                                    </a>
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="cutOverTime">10</span>
                                                        - เวลาประมวณผลเกิน
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <br>
                                        <b>คีย์เวิร์ด:</b>
                                        <br>
                                        <br>
                                        <ul id="list_keyword">
                                            <li ng-repeat="k in keywords"><%k.keyword_data%></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-warning" ng-click="editExam()" ng-show="createrID == thisUser.id">แก้ไข</button>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#tea_in_group_div').css('display', 'block');
            $('#side_group').attr('class','active');
//            $(".nav-tabs a").click(function () {
//                $(this).tab('show');
//            });
//            $('.nav-tabs a').on('shown.bs.tab', function (event) {
//                var x = $(event.target).text();         // active tab
//                var y = $(event.relatedTarget).text();  // previous tab
//                $(".act span").text(x);
//                $(".prev span").text(y);
//            });
        });

        function viewDetailExam(exam_id) {
            window.open(url+'/detailExam' + exam_id, '', 'scrollbars=1, width=1000, height=600');
            return false;
        }
    </script>
@endsection
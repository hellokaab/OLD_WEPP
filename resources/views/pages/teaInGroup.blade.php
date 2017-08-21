@extends('layouts.template')
@section('content')
    <script src="js/Components/teaInGroupCtrl.js"></script>
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
                            <th style="width: 20%;text-align: center">ซ่อน/แสดง</th>
                            <th style="width: 20%;text-align: center"></th>
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
                                        <input type="radio" name="hide_examing" id="hide_ex_<%e.id%>" value="0" ng-click="changeToHidden(e)">
                                        <label for="hide_ex" style="padding-left: 2px">ซ่อน</label>
                                    </div>
                                    <div class="col-md-6" style="text-align: center">
                                        <input type="radio" name="hide_examing" id="show_ex_<%e.id%>" value="1" ng-click="changeToShow(e)">
                                        <label for="show_ex" style="padding-left: 2px">แสดง</label>
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
                        <tr ng-hide="examingComing.length > 0">
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
                                <button class="btn btn-sm btn-outline-primary" title="รายละเอียด" style="cursor:pointer" ng-click="">
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

        <!-- Success Modal -->
        <div class="modal fade" id="success_modal" role="dialog">
            <div class="modal-dialog" style="width: 20%;padding-right: 12px">
                <div class="modal-content">
                    <div class="modal-body" style="text-align: center">
                        <h1 style="color: #28a745">สำเร็จ&nbsp;&nbsp;<i class="fa fa-check-circle" aria-hidden="true"></i></h1>
                    </div>
                    <div class="modal-footer">
                        <button id="okSuccess" type="button" class="btn btn-outline-success" data-dismiss="modal">ตกลง</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unsuccess Modal -->
        <div class="modal fade" id="unsuccess_modal" role="dialog">
            <div class="modal-dialog" style="width: 20%;padding-right: 12px">
                <div class="modal-content">
                    <div class="modal-body" style="text-align: center">
                        <h1 style="color: #dc3545">ผิดพลาด&nbsp;&nbsp;<i class="fa fa-times-circle" aria-hidden="true"></i></h1>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">ตกลง</button>
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
    </script>
@endsection
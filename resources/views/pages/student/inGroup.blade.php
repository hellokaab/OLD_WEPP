@extends('layouts.template')
@section('content')
    <script src="js/Components/student/inGroupCtrl.js"></script>
    <script>
        var groupId = {{$groupID}};
        var groupData = findGroupDataByID(groupId);
    </script>
    <div ng-controller="inGroupCtrl" style="display: none" id="in_group_div">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="<%myUrl%>/index">หน้าหลัก</a></li>
                <li>กลุ่มเรียน</li>
                <li><a href="<%myUrl%>/stdMyGroup">กลุ่มเรียนของฉัน</a></li>
                <li class="active"><%groupData.group_name%> (<%groupData.creater%>)</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default ">
                <div class="panel-heading" style="height: 54px"><label style="font-size: 20px;color: #337ab7;padding-top: 5px"><%groupData.group_name%> (<%groupData.creater%>)</label>
                    <button class="btn btn-outline-danger" href="" ng-click="exitGroup()" style="float: right"><i class="fa fa-sign-out"> </i> ออกจากกลุ่ม</button>
                </div>
                <div class="panel-body">
                    <label style="text-decoration:underline;font-size: 18px;padding-top: 5px">การสอบ</label>
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="width: 25%">ชื่อการสอบ</th>
                            <th style="width: 25%;text-align: center">เริ่มต้น</th>
                            <th style="width: 25%;text-align: center">สิ้นสุด</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="e in examingComing" ng-show="examingComing.length > 0">
                            <td><%e.examing_name%></td>
                            <td style="text-align: center"><%e.start_date_time%></td>
                            <td style="text-align: center"><%e.end_date_time%></td>
                            <td style="text-align: center">
                                <button id="btn_examing_<%e.id%>" style="visibility: hidden" class="btn btn-sm btn-outline-success" ng-click="admitExaming(e)">
                                    <i class="fa fa-sign-in fa-lg" aria-hidden="true"></i> เข้าสอบ
                                </button>
                            </td>
                        </tr>
                        <tr ng-hide="examingComing.length > 0">
                            <td>ไม่พบข้อมูล</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <div class="col-lg-12" style="padding: 0px">
                        <label style="text-decoration:underline;font-size: 18px;padding-top: 5px">ประวัติการสอบ</label>
                    </div>
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="width: 25%">ชื่อการสอบ</th>
                            <th style="width: 25%;text-align: center">เริ่มต้น</th>
                            <th style="width: 25%;text-align: center">สิ้นสุด</th>
                            <th style="width: 25%;text-align: center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="e in examingEnding" ng-show="examingEnding.length > 0">
                            <td><%e.examing_name%></td>
                            <td style="text-align: center"><%e.start_date_time%></td>
                            <td style="text-align: center"><%e.end_date_time%></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Exit Group Modal -->
        <div class="modal fade" id="exit_group_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-danger" id="exit_group_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #fff">ยืนยันการทำรายการ</h3>
                        </div>
                        <!-- Form -->
                        <div style="padding-top: 7%; text-align: center">คุณต้องการออกจากกลุ่มเรียนนี้หรือไม่</div>
                        <br>
                        <input style="margin-left: 10%; width: 80%" type="text" class="form-control text-center"
                               ng-model="groupName" disabled/>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" ng-click="okExit()">ตกลง</button>
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admit Modal -->
        <div class="modal fade" id="admit_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-success" id="admit_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title">รหัสผ่านเข้าสอบ</h3>
                        </div>
                        <div class="form-horizontal" role="form" style="padding-top: 7%">
                            <div class="form-group">
                                <label class="col-md-4 control-label">รหัสผ่านเข้าสอบ</label>
                                <div class = "col-md-6">
                                    <input id="examing_password" type="password" class="form-control" ng-model="examingPassword" ng-keyup="$event.keyCode === 13 && okAdmitExaming()" maxlength="8">
                                </div>
                            </div>
                            <!-- un use -->
                            <div class = "form-group"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" ng-click="okAdmitExaming()">ตกลง</button>
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">ยกเลิก</button>
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

        <!-- Network Fail Modal -->
        <div class="modal fade" id="network_fail_modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="panel panel-danger" style="margin-bottom: 0">
                        <!-- Panel header -->
                        <div class="panel-heading">
                            <h3 class="panel-title">ข้อจำกัดด้านเครือข่าย</h3>
                        </div>
                        <!-- Form -->
                        <div style="padding-top: 7%; text-align: center">เครือข่ายที่ท่านเชื่อมต่อไม่ได้รับอนุญาตให้ทำข้อสอบ</div>
                        <br>
                        <!-- Model footer -->
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
            $('#in_group_div').css('display', 'block');

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
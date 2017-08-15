@extends('layouts.template')
@section('content')
    <script src="js/Components/inGroupCtrl.js"></script>
    <script>
        var groupId = {{$groupID}};
        var groupData = findGroupDataByID(groupId);
    </script>
    <div ng-controller="inGroupCtrl" style="display: none" id="in_group_div">
        <div class="col-lg-12">
            <div class="panel panel-default ">
                <div class="panel-heading" style="height: 54px"><label style="font-size: 20px;color: #337ab7;padding-top: 5px"><%groupData.group_name%> (<%groupData.creater%>)</label>
                    <button class="btn btn-outline-danger" href="" ng-click="exitGroup()" style="float: right"><i class="fa fa-sign-out"> </i> ออกจากกลุ่ม</button>
                </div>
                <div class="panel-body">
                    <h4 style="text-decoration:underline">การสอบ</h4>
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
                            <td></td>
                        </tr>
                        <tr ng-hide="examingComing.length > 0">
                            <td>ไม่พบข้อมูล</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-show="memberList.length > 0" dir-paginate="m in memberList|orderBy:stu_id|itemsPerPage:selectRow">
                            <td><%m.stu_id%></td>
                            <td><%m.fullName%></td>
                        </tr>
                        <tr ng-hide="memberList.length > 0">
                            <td>ไม่พบรายชื่อสมาชิก</td>
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
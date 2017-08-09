@extends('layouts.template')
@section('content')
    <script src="js/Components/inGroupCtrl.js"></script>
    <script>
        var groupId = {{$groupID}};
        var groupData = findGroupDataByID(groupId);
        console.log(groupData);
    </script>
    <div ng-controller="inGroupCtrl" style="display: none" id="in_group_div">
        <div class="col-lg-12">
            <div class="panel panel-default ">
                <div class="panel-heading"><b><%groupData.group_name%> (<%groupData.creater%>)</b>
                    <a href="" ng-click="exitGroup()" style="float: right"><i class="fa fa-sign-out"> </i> ออกจากกลุ่ม</a>
                </div>
                <div class="panel-body"></div>
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
                    <div class="panel panel-default" id="exit_group_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #555">ยืนยันการทำรายการ</h3>
                        </div>
                        <!-- Form -->
                        <div style="padding-top: 7%; text-align: center">คุณต้องการออกจากกลุ่มเรียนนี้หรือไม่</div>
                        <br>
                        <input style="margin-left: 10%; width: 80%" type="text" class="form-control text-center"
                               ng-model="groupName" disabled/>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" ng-click="okExit()">ตกลง</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
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
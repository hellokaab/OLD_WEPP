@extends('layouts.template')
@section('content')
    <script src="js/Components/stdGroupCtrl.js"></script>
    <script>
        var allGroup = findAllGroup().responseJSON;
    </script>
    <div ng-controller="stdGroupCtrl" style="display: none" id="std_group_div">
        <div class="col-lg-12">
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <b>กลุ่มเรียน</b>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 col-xs-12" style="text-align: center">
                            <div class="form-group">
                                <label class="col-md-1 col-xs-2 control-label"
                                       style="margin-top: 14px;padding-right: 0px">ค้นหา</label>
                                <div class="col-md-4 col-xs-10" style="padding-right: 0px;padding-top: 7px">
                                    <input type="text" id="txt_search" class="form-control" ng-model="query[queryBy]"
                                           placeholder="ชื่อกลุ่มเรียน">
                                </div>
                                <label class="col-md-1 col-xs-2 control-label"
                                       style="margin-top: 14px;padding-right: 0px;text-align: center">จาก</label>
                                <div class="col-md-4 col-xs-10" style="padding-right: 0px;padding-top: 7px">
                                    <select class="form-control" ng-model="queryBy" ng-change="changePlaceholder()">
                                        <option value="group_name">ชื่อกลุ่มเรียน</option>
                                        <option value="creater">ผู้ดูแลกลุ่มเรียน</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12" style="text-align: center">
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
                            <th ng-click="sort('group_name')" style="cursor:pointer">กลุ่มเรียน  <i class="fa" ng-show="sortKey=='group_name'" ng-class="{'fa-chevron-up':reverseG,'fa-chevron-down':!reverseG}"></i></th>
                            <th ng-click="sort('creater')" style="cursor:pointer">ผู้ดูแลกลุ่ม  <i class="fa" ng-show="sortKey=='creater'" ng-class="{'fa-chevron-up':reverseC,'fa-chevron-down':!reverseC}"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-show="allGroup.length > 0" dir-paginate="g in allGroup|orderBy:[sortC,sortG]|filter:query|itemsPerPage:selectRow">
                            <td><a href="" ng-click="clickGroup(g)"><%g.group_name%></a></td>
                            <td><%g.creater%></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Join Group Modal -->
        <div class="modal fade" id="join_group_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-default" id="join_group_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #555">เข้าร่วมกลุ่ม</h3>
                        </div>
                        <div class="form-horizontal" role="form" style="padding-top: 7%">
                            <label class="col-md-4 control-label">ชื่อกลุ่มชื่อกลุ่มเรียน</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="groupName" disabled/>
                                </div>
                            </div>
                            <label class="col-md-4 control-label">รหัสเข้ากลุ่ม</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" class="form-control" ng-model="joinPass"
                                           maxlength="8"
                                           placeholder="อย่างน้อย 4 ตัวอักษร"/>
                                    <div class="notice" id="notice_pass_grp" style="display: none">
                                        รหัสผ่านไม่ถูกต้อง
                                    </div>
                                </div>
                            </div>
                            <!-- un use -->
                            <div class="form-group"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" ng-click="okJoinGroup()">ตกลง</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#std_group_div').css('display', 'block');

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
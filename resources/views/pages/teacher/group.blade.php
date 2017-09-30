@extends('layouts.template')

@section('content')
    <script src="js/Components/teacher/groupCtrl.js"></script>
    <script>
//        var groupList = findAllGroup().responseJSON;
//        console.log(groupList);
        var myGroupList = findMyGroup(myuser).responseJSON;
    </script>
    <div ng-controller="groupCtrl" style="display: none" id="group_div">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="<%myUrl%>/index">หน้าหลัก</a></li>
                <li class="active">กลุ่มเรียน</li>
            </ol>
        </div>
        <div class="col-lg-12">
        <div class="panel panel-default ">
            <div class="panel-heading" style="height: 51px"><label style="padding-top: 5px">กลุ่มเรียน</label>
                <button class="btn btn-sm btn-outline-success" href="" ng-click="addGroup()" style="float: right"><i class="fa fa-plus"> เพิ่มกลุ่มเรียน</i></button>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-md-1 col-xs-2 control-label" style="margin-top: 7px">ค้นหา</label>
                            <div class="col-md-4 col-xs-4" style="padding-left: 4px">
                                <input type="text" id="txt_search" class="form-control" ng-model="query[queryBy]"
                                       placeholder="ชื่อกลุ่มเรียน">
                            </div>
                        </div>
                    </div>
                    {{--    ---------------select--------------- --}}
                    <div class="col-md-4 col-xs-12" style="text-align:center">
                        <div class="form-group">
                            <label class="col-md-offset-4 col-md-2 col-xs-2 control-label " style="margin-top: 7px" >แสดง</label>
                            <div class="col-md-4 col-xs-8"  style="padding-right: 0px;">
                                <select class="form-control" ng-model="selectRow">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <label class="col-md-2 col-xs-4" style="margin-top: 7px">แถว</label>
                        </div>
                    </div> {{--    -------------End-select--------------- --}}
                </div>
                {{---=-=-=-=-=-=-=-=-=-=--=-=-=-=-=-=-=-=-=-=-=-=-=--}}
                <br/>
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th ng-click="sort('group_name')" style="cursor:pointer;width: 40%">ชื่อกลุ่มเรียน  <i class="fa" ng-show="sortKey=='group_name'" ng-class="{'fa-chevron-up':reverseS,'fa-chevron-down':!reverseS}"></i></th>
                                        <th style="width:40%">ผู้ดูแลกลุ่ม</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--@forelse($group as $name)--}}
                                    <tr ng-show="mygroup.length > 0" dir-paginate="m in mygroup|orderBy:[sortC,sortS]|filter:query|itemsPerPage:selectRow">
                                        <td><a href="" ng-click="inGroup(m)"><%m.group_name%></a></td>
                                        <td>อ.<%m.fname_th+" "+m.lname_th%></td>
                                        <td ng-hide="m.user_id == thisUser.id"></td>
                                        <td ng-show="m.user_id == thisUser.id" style="text-align: center">
                                            <button class="btn btn-sm btn-outline-warning" title="แก้ไขกลุ่มเรียน" style="cursor:pointer" ng-click="editGroup(m)">
                                                <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"
                                                   data-toggle="modal"></i>
                                            </button>
                                            &nbsp;&nbsp;
                                            <button class="btn btn-sm btn-outline-danger" title="ลบกลุ่มเรียน" style="cursor:pointer" ng-click="deleteGroup(m)">
                                                <i class="fa fa-trash fa-lg" aria-hidden="true" data-toggle="modal"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr ng-hide="mygroup.length > 0">
                                        <td>ไม่พบข้อมูล</td>
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
        </div>

    <!-- Add Group Modal -->
        <div class="modal fade" id="add_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-success" id="addGroupPart" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #fff">เพิ่มกลุ่มเรียน</h3>
                        </div>
                        <div class="form-horizontal" role="form" style="padding-top: 7%">
                            <label class="col-md-4 control-label">ชื่อกลุ่มเรียน</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="groupName"
                                           ng-keyup="$event.keyCode === 13 && enterAdd()" maxlength="200"/>
                                    <div class="notice" id="notice_name_add_grp" style="display: none">
                                        กรุณาระบุชื่อกลุ่มเรียน
                                    </div>
                                </div>
                            </div>
                            <label class="col-md-4 control-label">รหัสเข้ากลุ่ม</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" class="form-control" ng-model="passwordGroup"
                                           ng-keyup="$event.keyCode === 13 && enterOkAdd()" maxlength="8"
                                           placeholder="อย่างน้อย 4 ตัวอักษร"/>
                                    <div class="notice" id="notice_pass_add_grp" style="display: none">
                                        กรุณาระบุรหัสเข้ากลุ่ม
                                    </div>
                                </div>
                            </div>
                            <!-- un use -->
                            <div class="form-group"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" ng-click="okAddGroup()">ตกลง</button>
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--end--}}

    <!-- Delete Group Modal -->
        <div class="modal fade" id="delete_grp_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-danger" id="delete_group_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #fff">ยืนยันการลบรายการ</h3>
                        </div>
                        <div class="form-horizontal" role="form" style="padding-top: 7%">
                            <label class="col-md-4 control-label">กลุ่มการเรียน</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="groupName" disabled/>
                                </div>
                            </div>
                            <!-- un use -->
                            <div class="form-group"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" ng-click="okDeleteGroup()">ลบ</button>
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
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

        <!-- Fail Modal -->
        <div id="fail_modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title">ข้อผิดพลาด</h3>
                        </div>
                        <div style="padding-top: 7%; text-align: center" id="err_message">ไม่สามารถลบรายการนี้ได้
                            ข้อมูลถูกใช้งานอยู่
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ตกลง</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
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

        <script>
            $(document).ready(function () {
                $('#group_div').css('display', 'block');
                $('#side_group').attr('class','active');
                $(".nav-tabs a").click(function () {
                    $(this).tab('show');
                });
                $('.nav-tabs a').on('shown.bs.tab', function (event) {
                    var x = $(event.target).text();         // active tab
                    var y = $(event.relatedTarget).text();  // previous tab
                    $(".act span").text(x);
                    $(".prev span").text(y);
                });
            });
        </script>
    </div>
@endsection

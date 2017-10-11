@extends('layouts.template')

@section('content')
    <script src="js/Components/teacher/myWorksheetCtrl.js"></script>
    <script>
        var sheetGroup = dataSheetGroup(myuser).responseJSON;
    </script>
    <div ng-controller="myWorksheetCtrl" style="display: none"
         id="worksheet_div">  {{--style="display: none" id="worksheet_div"--}}
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="<%myUrl%>/index">หน้าหลัก</a></li>
                <li>คลังใบงาน</li>
                <li class="active">กลุ่มใบงานของฉัน</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="height: 51px"><label style="font-size: 18px;padding-top: 5px">กลุ่มใบงานของฉัน</label>
                    <button class="btn btn-sm btn-outline-success" href="" ng-click="addMyWorksheetGroup()"
                            style="float: right">
                        <i class="fa fa-plus"> เพิ่มกลุ่มใบงาน</i></button>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 col-xs-12" style="text-align: center">
                            <div class="form-group">
                                <label class="col-md-1 col-xs-2 control-label"
                                       style="margin-top: 14px;padding-right: 0px">ค้นหา</label>
                                <div class="col-md-4 col-xs-10" style="padding-right: 0px;padding-top: 7px">
                                    <input type="text" id="txt_search" class="form-control" ng-model="query"
                                           placeholder="ชื่อกลุ่มข้อสอบ">
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
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th ng-click="sort('sheet_group_name')" style="cursor:pointer;width: 40%">
                                กลุ่มใบงาน <i class="fa" ng-show="sortKey=='sheet_group_name'"
                                              ng-class="{'fa-chevron-up':reverseS,'fa-chevron-down':!reverseS}"></i>
                            </th>
                            <th>ผู้สร้างกลุ่มใบงาน</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-show="sheetGroup.length > 0"
                            dir-paginate="s in sheetGroup|orderBy:[sortC,sortS]|filter:query|itemsPerPage:selectRow">
                            <td><a href="#listWorksheet" ng-click="keptID(s)"><%s.sheet_group_name%></a>
                            </td>
                            <td>อ.<%s.fname_th+" "+s.lname_th%></td>
                            <td ng-hide="s.user_id == thisUser.id"></td>
                            <td ng-show="s.user_id == thisUser.id" style="text-align: center">
                                <button class="btn btn-outline-warning" title="แก้ไขกลุ่มใบงาน"
                                        style="cursor:pointer" ng-click="editWorksheet(s)">
                                    <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                                </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-outline-danger" title="ลบกลุ่มใบงาน"
                                        style="cursor:pointer" ng-click="deleteWorksheet(s)">
                                    <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <tr ng-hide="sheetGroup.length > 0">
                            <td>ไม่พบข้อมูล</td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <dir-pagination-controls
                            max-size="5"
                            direction-links="true"
                            boundary-links="true">
                    </dir-pagination-controls>
                </div>
                <div class="panel-footer">
                    <b class="notice">*</b> คลิกที่ชื่อกลุ่มใบงานเพื่อดูใบงาน
                </div>
            </div>
        </div>

        <div id="listWorksheet" style="display: none" class="col-lg-7">
            <div class="panel panel-default" ng-repeat="s in sheetGroup" ng-hide="sheetGroupId != <%s.id%>">
                <div class="panel-heading" style="height: 51px">
                    <label style="color: #555;padding-top: 5px"><%s.sheet_group_name%></label>
                    <button class="btn btn-sm btn-outline-success" ng-hide="<%s.user_id%> != thisUser.id"
                            ng-click="addWorksheet()" style="float: right"><i class="fa fa-plus"></i>
                        เพิ่มใบงาน
                    </button>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ใบงาน</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="sh in mySheet" ng-if="sh.sheet_group_id === s.id">
                            <td><a href=""><%sh.sheet_name%></a></td>
                            <td  style="text-align: center;width: 30%" >
                                <button class="btn btn-outline-primary btn-sm" title="รายละเอียด" style="cursor:pointer">
                                    <i class="fa fa-tasks fa-lg" aria-hidden="true"></i>
                                </button>
                                &nbsp;
                                <button class="btn btn-outline-warning btn-sm" title="แก้ไขใบงาน" style="cursor:pointer">
                                    <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                                </button>
                                &nbsp;
                                <button class="btn btn-outline-danger btn-sm" title="ลบใบงาน" style="cursor:pointer">
                                    <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add worksheet Modal -->
        <div class="modal fade" id="add_WorkSheet_Group_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-success" id="addWorkSheetGroupPart" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #fff">เพิ่มกลุ่มใบงาน</h3>
                        </div>
                        <div class="form-horizontal" role="form" style="padding-top: 7%">
                            <label class="col-md-4 control-label">ชื่อกลุ่มใบงาน</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="MySheetName"
                                           ng-keyup="$event.keyCode === 13 && enterAdd()" maxlength="200"/>
                                    <div class="notice" id="notice_name_add_mwsg" style="display: none">
                                        กรุณาระบุชื่อกลุ่มใบงาน
                                    </div>
                                </div>
                            </div>
                            <!-- un use -->
                            <div class="form-group"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" ng-click="okAddMyWorksheetGroup()">
                                ตกลง
                            </button>
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{--end--}}

    <!-- Delete WorksheetGroup Modal -->
        <div class="modal fade" id="delete_wsg_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-danger" id="delete_WorksheetGroup_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #fff">ยืนยันการลบรายการ</h3>
                        </div>
                        <div class="form-horizontal" role="form" style="padding-top: 7%">
                            <label class="col-md-4 control-label">กลุ่มใบงาน</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="MySheetName" disabled/>
                                </div>
                            </div>
                            <!-- un use -->
                            <div class="form-group"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" ng-click="okDeleteWorksheetGroup()">
                                ลบ
                            </button>
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Worksheet Group -->
        <div class="modal fade" id="edit_worksheet_group_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-warning" id="edit_worksheet_group_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #fff">แก้ไขกลุ่มใบงาน</h3>
                        </div>
                        <div class="form-horizontal" role="form" style="padding-top: 7%">
                            <div class="form-group">
                                <label class="col-md-4 control-label">ชื่อกลุ่มใบงาน</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" ng-model="MySheetName"
                                           ng-keyup="$event.keyCode === 13 && enterOkEdit()" maxlength="200"/>
                                    <div class="notice" id="notice_edit_worksheetGroup_ewsg" style="display: none">
                                        *กรุณาระบุชื่อกลุ่มใบงาน
                                    </div>
                                </div>
                            </div>
                            <!-- un use -->
                            <div class="form-group"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-warning" ng-click="okEditExamGroup()">บันทึก
                            </button>
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#worksheet_div').css('display', 'block');
            $("#side_sheet_store").removeAttr('class');
            $('#side_sheet_store').attr('class', 'active');
            $("#sheet_chevron").removeAttr('class');
            $("#sheet_chevron").attr('class', 'fa2 fa-chevron-down');
            $('#demo4').attr('class', 'collapse in');
            $('#side_my_Worksheet').attr('class', 'active');

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
@endsection
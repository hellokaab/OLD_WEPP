@extends('layouts.template')
@section('content')
    <script src="js/Components/teacher/openWorksheetHistoryCtrl.js"></script>
    <script>
        var myGroup = findMyGroup(myuser).responseJSON;
        var mySheeting = findSheetingByUserID(myuser.id);
    </script>
    <div ng-controller="openWorksheetHistoryCtrl" style="display: none" id="open_sheet_history_div">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="<%myUrl%>/index">หน้าหลัก</a></li>
                <li>จัดการการสั่งงาน</li>
                <li class="active">ประวัติการสั่งงาน</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b style="color: #555">ประวัติการสั่งงาน</b>
                </div>
                <div class="panel-body">
                    <br>
                    <div class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-md-2 control-label">กลุ่มเรียน: </label>
                            <div class="col-md-5">
                                <select class="form-control" ng-model="groupId">
                                    <option value="0">กรุณาเลือก</option>
                                    <option ng-repeat="g in groups" value="<%g.id%>"><%g.group_name%></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" ng-show="groupId != 0">
                        <div class="col-md-8 col-xs-12" style="text-align: center">
                            <div class="form-group">
                                <label class="col-md-1 col-xs-2 control-label"
                                       style="margin-top: 14px;padding-right: 0px">ค้นหา</label>
                                <div class="col-md-4 col-xs-10" style="padding-right: 0px;padding-top: 7px">
                                    <input type="text" id="txt_search" class="form-control" ng-model="query"
                                           placeholder="ชื่อการสอบ">
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
                    <div ng-show="groupId != 0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 20%">ชื่อการสั่งงาน</th>
                                    <th style="width: 20%;text-align: center">เริ่มต้น</th>
                                    <th style="width: 20%;text-align: center">สิ้นสุด</th>
                                    <th style="width: 15%;text-align: center">ส่งเกินเวลา</th>
                                    <th style="width: 25%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-show="groupId == sh.group_id" dir-paginate="sh in sheeting|filter:query|itemsPerPage:selectRow">
                                    <td><%sh.sheeting_name%></td>
                                    <td style="text-align: center"><%sh.start_date_time%></td>
                                    <td style="text-align: center"><%sh.end_date_time%></td>
                                    <td ng-show="sh.send_late === '0'" style="text-align: center">ไม่อนุญาต</td>
                                    <td ng-show="sh.send_late === '1'" style="text-align: center">อนุญาต</td>
                                    <td style="text-align: center;width: 20%">
                                        <button class="btn btn-sm btn-outline-warning" title="แก้ไข" style="cursor:pointer" ng-click="editSheeting(sh)">
                                            <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                                        </button>
                                        &nbsp;
                                        <button class="btn btn-sm btn-outline-danger" title="ลบ" style="cursor:pointer" ng-click="deleteSheeting(sh)">
                                            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="delete_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-danger" id="delete_sheeting_part" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title">ยืนยันการทำรายการ</h3>
                        </div>
                        <div style="padding-top: 7%; text-align: center">คุณต้องการลบประวัติการสั่งงานนี้หรือไม่</div>
                        <br>
                        <input ng-model="sheetingName" value="" style="margin-left: 10%; width: 80%" type="text" class="form-control text-center"  disabled/>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" ng-click="okDeleteSheeting()">ตกลง</button>
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#open_sheet_history_div').css('display','block');
            $("#side_sheeting").removeAttr('class');
            $('#side_sheeting').attr('class', 'active');
            $("#sheeting_chevron").removeAttr('class');
            $("#sheeting_chevron").attr('class','fa2 fa-chevron-down');
            $('#demo2').attr('class', 'collapse in');
            $('#side_historySheeting').attr('class', 'active');
        });
    </script>

@endsection
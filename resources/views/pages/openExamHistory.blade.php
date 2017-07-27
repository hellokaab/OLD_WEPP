@extends('layouts.template')
@section('content')
    <script src="js/Components/openExamHistoryCtrl.js"></script>
    <script>
        var myGroup = findMyGroup(myuser).responseJSON;
        var myExaming = findExamingByUserID(myuser.id);
    </script>
    <div ng-controller="openExamHistoryCtrl" style="display: none" id="openExamHistory_div">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b style="color: #555">ประวัติการเปิดสอบ</b>
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
                                    <th style="width: 20%">ชื่อการสอบ</th>
                                    <th style="width: 20%">โหมดการสอบ</th>
                                    <th style="width: 20%;text-align: center">เริ่มต้น</th>
                                    <th style="width: 20%;text-align: center">สิ้นสุด</th>
                                    <th style="width: 20%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr dir-paginate="e in examings|filter:query|itemsPerPage:selectRow">
                                    <td><%e.examing_name%></td>
                                    <td ng-show="e.examing_mode === 'n'">เรียงตามลำดับ</td>
                                    <td ng-show="e.examing_mode === 'r'">สุ่ม</td>
                                    <td style="text-align: center"><%e.start_date_time%></td>
                                    <td style="text-align: center"><%e.end_date_time%></td>
                                    <td style="text-align: center;width: 20%">
                                        <a title="แก้ไข" style="cursor:pointer;color: #f0ad4e" href="<%myUrl%>/editOpenExam<%e.id%>">
                                            <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                                        </a>
                                        &nbsp;&nbsp;
                                        <a title="ลบ" style="cursor:pointer;color: #d9534f">
                                            <i class="fa fa-trash fa-lg" aria-hidden="true"
                                               ng-click="deleteExaming(e)"></i>
                                        </a>
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
                    <div class="panel panel-danger" id="deleteExamingPart" style="margin-bottom: 0;border-color: #d43f3a">
                        <div class="panel-heading" style="background-color: #d9534f">
                            <h3 class="panel-title">ยืนยันการทำรายการ</h3>
                        </div>
                        <div style="padding-top: 7%; text-align: center">คุณต้องการลบประวัติการเปิดสอบนี้หรือไม่</div>
                        <br>
                        <input ng-model="examingName" value="" style="margin-left: 10%; width: 80%" type="text" class="form-control text-center"  disabled/>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" ng-click="okDeleteExaming()">ตกลง</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#openExamHistory_div').css('display','block');
        });
    </script>
@endsection

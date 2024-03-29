@extends('layouts.template')

@section('content')
    <script src="js/Components/teacher/shareWorksheetCtrl.js"></script>
    <div ng-controller="shareWorksheetCtrl" style="display: none" id="share_sheet_div">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/index')}}">หน้าหลัก</a></li>
                <li>คลังใบงาน</li>
                <li class="active">กลุ่มใบงานที่แบ่งปันกับฉัน</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b style="color: #555">กลุ่มใบงานที่แบ่งปันกับฉัน</b>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 col-xs-12" style="text-align: center">
                            <div class="form-group">
                                <label class="col-md-1 col-xs-2 control-label"
                                       style="margin-top: 14px;padding-right: 0px">ค้นหา</label>
                                <div class="col-md-4 col-xs-10" style="padding-right: 0px;padding-top: 7px">
                                    <input type="text" id="txt_search" class="form-control" ng-model="query"
                                           placeholder="ชื่อกลุ่มใบงาน">
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
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th ng-click="sort('sheet_group_name')" style="cursor:pointer">กลุ่มข้อสอบ  <i class="fa" ng-show="sortKey=='sheet_group_name'" ng-class="{'fa-caret-up':reverseS,'fa-caret-down':!reverseS}"></i></th>
                            <th ng-click="sort('creater')" style="cursor:pointer">ผู้สร้างกลุ่มข้อสอบ  <i class="fa" ng-show="sortKey=='creater'" ng-class="{'fa-caret-up':reverseC,'fa-caret-down':!reverseC}"></i></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-show="sheetGroupSharedToMe.length > 0" dir-paginate="sg in sheetGroupSharedToMe|orderBy:[sortC,sortS]|filter:query|itemsPerPage:selectRow">
                            <td><a href="#divSheetList" ng-click="changeGroup(sg)"><%sg.sheet_group_name%></a></td>
                            <td style="width: 40%;"><%sg.creater%></td>
                            <td></td>
                        </tr>
                        <tr ng-hide="sheetGroupSharedToMe.length > 0">
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
                <div class="panel-footer" id="move">
                    <b class="notice">*</b> คลิกที่ชื่อกลุ่มใบงานเพื่อรายชื่อใบงาน
                </div>
            </div>
        </div>

        {{--Exam List--}}
        <div class="col-lg-7" id="divSheetList" style="display: none">
            <div class="panel panel-default" ng-repeat="sg in sheetGroupSharedToMe" ng-hide="sheetGroupId != <%sg.id%>">
                <div class="panel-heading">
                    <b style="color: #555"><%sg.sheet_group_name%></b>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th style="width: 60%">ใบงาน</th>
                            <th style="width: 40%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="sh in sheetSharedToMe" ng-if="sh.sheet_group_id === sg.id">
                            <td><a href="" ng-click="detailWorksheet(sh)"><%sh.sheet_name%></a></td>
                            <td style="text-align: center" ng-show="sh.user_id != thisUser.id">
                                <button class="btn btn-sm btn-outline-primary" title="รายละเอียด" style="cursor:pointer" ng-click="detailWorksheet(sh)">
                                    <i class="fa fa-tasks fa-lg" aria-hidden="true"></i>
                                </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-sm btn-outline-success" title="คัดลอกใบงาน" style="cursor:pointer" ng-click="copyWorksheet(sh)">
                                    <i class="fa fa-clone fa-lg" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detail Worksheet Modal -->
        <div class="modal fade" id="detail_sheet_modal" role="dialog">
            <div class="modal-dialog" style="width: 98%; padding-right: 12px">
                <div class="modal-content">
                    <div class="panel panel-primary" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #fff">รายละเอียดใบงาน</h3>
                        </div>
                        <div class="panel-body">
                            <h4 class="text-center" id="sheetName"></h4>
                            <br>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <br>
                                        <b>วัตถุประสงค์:</b>
                                        <div id="objective_part">
                                            <textarea class="form-control code_textarea" style="background-color: #fff"
                                                      id="objective" rows="5" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <b>ทฤษฎีที่เกี่ยวข้อง:</b>
                                        <div id="theory_part">
                                            <textarea class="form-control code_textarea" style="background-color: #fff"
                                                      id="theory" rows="5" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <b>การทดลอง:</b>
                                <div id="sheet_trial"></div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <br>
                                        <b>อินพุท:</b>
                                        <div id="input_part">
                                            <textarea class="form-control code_textarea" style="background-color: #fff"
                                                      id="sheetInput" rows="10" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <b>เอาท์พุท:</b>
                                        <div id="output_part">
                                            <textarea class="form-control code_textarea" style="background-color: #fff"
                                                      id="sheetOutput" rows="10" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="list-group">
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="fullScore">100</span>
                                                        คะแนนเต็มของใบงาน
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12"><b>หมายเหตุ : </b></div>
                                            <div class="col-md-6"><span id="notation"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <h4 style="padding-left: 15px">คำถามท้ายการทดลอง</h4>
                            <div class="col-md-6" ng-repeat="q in quizzes" style="margin-top: 20px">
                                <div class="row">
                                    <div class="col-md-12">
                                        <b>คำถามข้อที่ <%$index+1%>:</b>
                                        <div>
                                            <textarea class="form-control code_textarea" style="background-color: #fff"
                                                      id="quiz_1" rows="3" disabled><%q.quiz_data%></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <b>คำตอบ :</b>
                                        <div>
                                            <input type="text" class="form-control" style="background-color: #fff"
                                                   id="answer_1" value="<%q.quiz_ans%>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <b>คะแนน :</b>
                                        <div>
                                            <input type="text" class="form-control" style="background-color: #fff"
                                                   id="score_1" value="<%q.quiz_score%>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#share_sheet_div').css('display', 'block');
            $("#side_sheet_store").removeAttr('class');
            $('#side_sheet_store').attr('class', 'active');
            $("#sheet_chevron").removeAttr('class');
            $("#sheet_chevron").attr('class','fa2 fa-chevron-down');
            $('#demo4').attr('class', 'collapse in');
            $('#side_shared_Worksheet').attr('class', 'active');
        });
    </script>
@endsection
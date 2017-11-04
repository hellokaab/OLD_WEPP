@extends('layouts.template')
@section('content')
    <script src="js/Components/teacher/examCtrl.js"></script>
    <script>
        var exams = findAllExam().responseJSON;
//        var allsections = findAllSection().responseJSON;
//        var mysections = findMySection(myuser).responseJSON;
    </script>
    <div ng-controller="examCtrl" style="display: none" id="exam_div">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="<%myUrl%>/index">หน้าหลัก</a></li>
                <li>คลังข้อสอบ</li>
                <li class="active">กลุ่มข้อสอบที่แบ่งปันกับฉัน</li>
            </ol>
        </div>
        {{--Exam Group List--}}
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b style="color: #555">กลุ่มข้อสอบที่แบ่งปันกับฉัน</b>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 col-xs-12" style="text-align: center">
                            <div class="form-group">
                                <label class="col-md-1 col-xs-2 control-label"
                                       style="margin-top: 14px;padding-right: 0px">ค้นหา</label>
                                <div class="col-md-4 col-xs-10" style="padding-right: 0px;padding-top: 7px">
                                    <input type="text" id="txt_search" class="form-control" ng-model="query[queryBy]"
                                           placeholder="ชื่อกลุ่มข้อสอบ">
                                </div>
                                <label class="col-md-1 col-xs-2 control-label"
                                       style="margin-top: 14px;padding-right: 0px;text-align: center">จาก</label>
                                <div class="col-md-4 col-xs-10" style="padding-right: 0px;padding-top: 7px">
                                    <select class="form-control" ng-model="queryBy" ng-change="changePlaceholder()">
                                        <option value="section_name">ชื่อกลุ่มข้อสอบ</option>
                                        <option value="creater">ผู้สร้างกลุ่มข้อสอบ</option>
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
                            <th ng-click="sort('section_name')" style="cursor:pointer">กลุ่มข้อสอบ  <i class="fa" ng-show="sortKey=='section_name'" ng-class="{'fa-caret-up':reverseS,'fa-caret-down':!reverseS}"></i></th>
                            <th ng-click="sort('creater')" style="cursor:pointer">ผู้สร้างกลุ่มข้อสอบ  <i class="fa" ng-show="sortKey=='creater'" ng-class="{'fa-caret-up':reverseC,'fa-caret-down':!reverseC}"></i></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-show="sectionSharedToMe.length > 0" dir-paginate="g in sectionSharedToMe|orderBy:[sortC,sortS]|filter:query|itemsPerPage:selectRow">
                            <td><a href="#divExamList" ng-click="changeGroup(g)"><%g.section_name%></a></td>
                            <td style="width: 40%;"><%g.creater%></td>
                            <td ng-hide="g.user_id == thisUser.id"></td>
                        </tr>
                        <tr ng-hide="sectionSharedToMe.length > 0">
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
                    <b class="notice">*</b> คลิกที่ชื่อกลุ่มข้อสอบเพื่อรายชื่อข้อสอบ
                </div>
            </div>
        </div>

        {{--Exam List--}}
        <div class="col-lg-7" id="divExamList" style="display: none">
            <div class="panel panel-default" ng-repeat="g in sectionSharedToMe" ng-hide="groupId != <%g.id%>">
                <div class="panel-heading">
                    <b style="color: #555"><%g.section_name%></b>
                    <a ng-hide="<%g.user_id%> != thisUser.id" href="<%myUrl%>/addExam<%groupId%>" style="float: right"><i class="fa fa-plus"></i>
                        เพิ่มข้อสอบ</a>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th style="width: 60%">โจทย์</th>
                            <th style="width: 40%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="e in examShareToMe" ng-if="e.section_id === g.id">
                            <td><a href="" ng-click="detailExam(e)"><%e.exam_name%></a></td>
                            <td style="text-align: center" ng-show="e.user_id != thisUser.id">
                                <button class="btn btn-sm btn-outline-primary" title="รายละเอียด" style="cursor:pointer" ng-click="detailExam(e)">
                                    <i class="fa fa-tasks fa-lg" aria-hidden="true"></i>
                                </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-sm btn-outline-success" title="คัดลอกข้อสอบ" style="cursor:pointer"
                                   ng-click="copyExam(e)">
                                    <i class="fa fa-clone fa-lg" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detail Exam Modal -->
        <div class="modal fade" id="detail_exam_modal" role="dialog">
            <div class="modal-dialog" style="width: 98%; padding-right: 12px">
                <div class="modal-content">
                    <div class="panel panel-primary" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="color: #fff">รายละเอียดข้อสอบ</h3>
                        </div>
                        <div class="panel-body">

                            <h4 class="text-center" id="examName"></h4>
                            <br>
                            <div class="col-md-3"><b>Time limit:</b> <span id="examTimeLimit"></span> Seconds</div>
                            <div class="col-md-3"><b>Memory limit:</b> <span id="examMemLimit"></span> KB</div>
                            <div class="col-md-12">
                                <br>
                                <b>โจทย์:</b>
                                <div id="exam_content"></div>
                            </div>


                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <br>
                                        <b>อินพุท:</b>
                                        <div id="input_part">
                                            <textarea class="form-control code_textarea" style="background-color: #fff"
                                                      id="examInput" rows="10" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <b>เอาท์พุท:</b>
                                        <div id="output_part">
                                            <textarea class="form-control code_textarea" style="background-color: #fff"
                                                      id="examOutput" rows="10" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <b>เกณฑ์การให้คะแนน:</b>
                                                <div class="list-group">
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="fullScore">100</span>
                                                        - คะแนนเต็ม
                                                    </a>
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="imperfect">50</span>
                                                        - คำตอบถูกต้องบางส่วน (% ของคะแนนเต็ม)
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <b>เกณฑ์การหักคะแนน:</b>
                                                <div class="list-group">
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="cutWrongAnswer">10</span>
                                                        - คำตอบผิดพลาด
                                                    </a>
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="cutComplieError">10</span>
                                                        - รูปแบบโค้ดไม่ถูกต้อง
                                                    </a>
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="cutOverMem">10</span>
                                                        - หน่วยความจำเกิน
                                                    </a>
                                                    <a class="list-group-item">
                                                        <span class="badge badge-default" id="cutOverTime">10</span>
                                                        - เวลาประมวณผลเกิน
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <br>
                                        <b>คีย์เวิร์ด:</b>
                                        <br>
                                        <br>
                                        <ul id="list_keyword">
                                            <li ng-repeat="k in keywords"><%k.keyword_data%></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" ng-click="editExam()" ng-show="createrID == thisUser.id">แก้ไข</button>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#exam_div').css('display', 'block');
            $("#side_exam_store").removeAttr('class');
            $('#side_exam_store').attr('class', 'active');
            $("#exam_chevron").removeAttr('class');
            $("#exam_chevron").attr('class','fa2 fa-chevron-down');
            $('#demo3').attr('class', 'collapse in');
            $('#side_shared_exam').attr('class', 'active');

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
@extends('layouts.template')
@section('content')
    <script src="js/Components/openExamCtrl.js"></script>
    <script>
        var myGroup = findMyGroup(myuser).responseJSON;
        var sections = findSectionSharedToMe(myuser.id);
        var exams = findExamSharedToMe(myuser.id);
    </script>
    <div ng-controller="openExamCtrl" style="display: none" id="openExam_div">
        <div class="col-lg-12">
            <div class="panel panel-default" id="open_exam_part">
                <div class="panel-heading">
                    <b style="color: #555">ตั้งค่าการเปิดสอบ</b>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal" role="form">
                        {{--Examing Name--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">ชื่อการสอบ: <b class="danger">*</b></label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" ng-model="openExamName" maxlength="200" autofocus/>
                                <div class="notice" id="notice_examing_name" style="display: none">กรุณาระบุชื่อการสอบ</div>
                            </div>
                        </div>

                        {{--Select Group--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">กลุ่มเรียน: <b class="danger">*</b></label>
                            <div class="col-md-5">
                                <select class="form-control" ng-model="userGroupId">
                                    <option value="0">กรุณาเลือก</option>
                                    <option ng-repeat="g in myGroups" value="<%g.id%>"><%g.group_name%></option>
                                </select>
                                <div class="notice" id="notice_examing_usr_grp" style="display: none">กรุณาระบุกลุ่มเรียน</div>
                            </div>
                        </div>

                        {{--Select Exam--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">ข้อสอบ: <b class="danger">*</b></label>
                            <div class="col-md-8">
                                <div class="row">
                                    <label class="control-label" style="padding-left: 15px" ng-show="sections.length == 0">ไม่พบข้อมูล</label>
                                    <div class="col-md-12 checkbox" ng-repeat="s in sections">
                                        <a href="" ng-click="viewExam(s.id)">
                                            <i id="group_<%s.id%>" class="fa fa-plus-square"></i> <%s.section_name%>
                                        </a>
                                        &nbsp;&nbsp;&nbsp;<b style="font-weight: 500" ng-show="s.user_id != thisUser.id">(<%s.creater%>)</b>
                                        <div style="padding-left: 50px; padding-top: 5px; display: none" ng-repeat="e in exams" ng-if="e.section_id === s.id">
                                            <input type="checkbox" id="exam_<%e.id%>" ng-click="ticExam()">
                                            <label style="padding: 0" for="exam_<%e.id%>" ng-click="ticExam()"><%e.exam_name%></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--Exam Mode--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">โหมดการสอบ:</label>
                            <div class="col-md-8">
                                <div class="radio">
                                    <div class="col-md-3">
                                        <input type="radio" name="examingMode" id="normalChk" value="n" ng-model="examingMode">
                                        <label for="normalChk" style="padding: 0">เรียงตามลำดับ</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="examingMode" id="randomChk" value="r" ng-model="examingMode">
                                        <label for="randomChk" style="padding: 0">สุ่ม</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--Amount--}}
                        <div class="form-group" ng-show="examingMode === 'r'">
                            <label class="col-md-2 control-label">จำนวนข้อ: <b class="danger">*</b></label>
                            <div class="col-md-3">
                                <select class="form-control">
                                    <option value="<%a%>" ng-model="amountExam" ng-repeat="a in randomExam"><%a%></option>
                                </select>
                            </div>
                        </div>

                        {{--Begin Time--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">เวลาเริ่มสอบ <b class="danger">*</b></label>
                            <div class="col-md-5">
                                <input type="text" style="background-color: #fff;cursor: pointer" class="form-control examingBegin" id="examingBegin" data-field="datetime" data-startend="start" data-startendelem=".examingEnd" readonly placeholder="คลิกเลือกเวลา"/>
                                <div class="notice" id="notice_examing_begin" style="display: none">กรุณาระบุเวลาเริ่มสอบ</div>
                            </div>
                        </div>

                        {{--End Time--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">เวลาสิ้นสุดการสอบ <b class="danger">*</b></label>
                            <div class="col-md-5">
                                <input type="text" style="background-color: #fff;cursor: pointer" class="form-control examingEnd" id="examingEnd" data-field="datetime" data-startend="end" data-startendelem=".examingBegin" readonly placeholder="คลิกเลือกเวลา"/>
                                <div class="notice" id="notice_examing_end" style="display: none">กรุณาระบุเวลาสิ้นสุดการสอบ</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="dtBox"></div>
    </div>

    <script>
        $(document).ready(function () {
            $('#openExam_div').css('display','block');
            $('[ng-model=userGroupId]').val(0);
            setDataTimePart();
        });

        function setDataTimePart() {
            var bIsPopup = displayPopup();

            $("#dtBox").DateTimePicker({
                isPopup: bIsPopup,
                addEventHandlers: function () {
                    var dtPickerObj = this;
                    $(window).resize(function () {
                        bIsPopup = displayPopup();
                        dtPickerObj.setIsPopup(bIsPopup);
                    });
                }
            });
        }
        function displayPopup() {
            if ($(document).width() >= 768)
                return true;
            else
                return true;
        }
    </script>
@endsection
@extends('layouts.template')
@section('content')
    <script src="js/Components/teacher/editExamingCtrl.js"></script>
    <script>
        var examingID = {{$examingID}};
        var myGroup = findMyGroup(myuser).responseJSON;
        var sections = findSectionSharedToMe(myuser.id);
        var exams = findExamSharedToMe(myuser.id);
        var exam_examing = findExamExamingByExamingID(examingID);
    </script>
    <div ng-controller="editOpenExamingCtrl" style="display: none" id="editOpenExam_div">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/index')}}">หน้าหลัก</a></li>
                <li>จัดการการสอบ</li>
                <li><a href="{{ url('/examingHistory')}}">ประวัติการเปิดสอบ</a></li>
                <li class="active">แก้ไขการเปิดสอบ</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default" id="edit_examing_part">
                <div class="panel-heading">
                    <b style="color: #555">แก้ไขการเปิดสอบ</b>
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
                                <select class="form-control" ng-model="userGroupId" id="group_id">
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
                                        <input type="checkbox" id="sec_<%s.id%>" style="margin-left: 0px" ng-click="ticAllInSec(s.id)">
                                        <a href="" ng-click="viewExam(s.id)" style="padding-left: 20px">
                                            <i id="group_<%s.id%>" class="fa fa-plus-square"></i> <%s.section_name%>
                                        </a>
                                        &nbsp;&nbsp;&nbsp;<b style="font-weight: 500" ng-show="s.user_id != thisUser.id">(<%s.creater%>)</b>
                                        <div style="padding-left: 50px; padding-top: 5px; display: none" ng-repeat="e in exams" ng-if="e.section_id === s.id">
                                            <input type="checkbox" id="exam_<%e.id%>" ng-click="ticExam()">
                                            <label style="padding: 0" for="exam_<%e.id%>" ng-click="ticExam()"><%e.exam_name%></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="notice" id="notice_exam" style="display: none">กรุณาระบุข้อสอบที่ใช้ในการสอบ</div>
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

                        <!-- Password -->
                        <div class="form-group">
                            <label class="col-md-2 control-label">รหัสเข้าสอบ</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" ng-model="examingPassword" maxlength="8"/>
                                <a href="" style="float: right; margin-top: 5px" ng-click="randomPassword()">
                                    <i class="fa fa-random" aria-hidden="true"></i> สุ่มรหัสผ่าน
                                </a>
                            </div>
                        </div>

                        {{--Select File Type--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">ไฟล์ที่อนุญาตให้ส่ง:</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-2 checkbox">
                                        <input type="checkbox" id="file_type_c" value="c" style="margin-left: 0px">
                                        <label for="file_type_c">.c</label>
                                    </div>
                                    <div class="col-md-2 checkbox">
                                        <input type="checkbox" id="file_type_cpp" value="cpp" style="margin-left: 0px">
                                        <label for="file_type_cpp">.cpp</label>
                                    </div>
                                    <div class="col-md-2 checkbox">
                                        <input type="checkbox" id="file_type_java" value="java" style="margin-left: 0px">
                                        <label for="file_type_java">.java</label>
                                    </div>
                                    <div class="col-md-2 checkbox">
                                        <input type="checkbox" id="file_type_cs" value="cs" style="margin-left: 0px">
                                        <label for="file_type_cs">.cs</label>
                                    </div>
                                </div>
                                <div class="notice" id="notice_file_type" style="display: none">กรุณาระบุไฟล์ที่อนุญาตให้ส่ง</div>
                            </div>
                        </div>

                        <!-- IP -->
                        <div class="form-group">
                            <label class="col-md-2 control-label">จำกัดเฉพาะ IP:</label>
                            <div class="col-md-8">
                                <div class="radio">
                                    <div class="col-md-2">
                                        <input type="radio" name="limitIp" id="unlimitIP" value="0" ng-model="ipMode">
                                        <label for="unlimitIP">ไม่ใช่</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="limitIp" id="limitIP" value="1" ng-model="ipMode">
                                        <label for="limitIP">ใช่</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gateway IP -->
                        <div class="form-group" ng-show="ipMode === '1'">
                            <label class="col-md-2 control-label">IP Router/Gateway:</label>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" ng-model="gatewayIp" maxlength="15" placeholder="เช่น 172.17.5.254"/>
                                        <button ng-click="addNetwork()" class="btn btn-outline-info" style="margin-top: 15px"><i class="fa fa-arrow-down" aria-hidden="true"></i> เพิ่มเครือข่าย</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" ng-show="ipMode === '1'">
                            <label class="col-md-2 control-label">เครือข่ายที่ได้รับอนุญาต</label>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea type="text" class="form-control io_textarea time" ng-model="allowNetwork" maxlength="100" rows="5" disabled></textarea>
                                        <a href="" style="float: right" ng-click="clearIP()"><i class="fa fa-refresh" aria-hidden="true"></i> ล้างรายการเครือข่าย</a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{--Hide Examing--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">แสดงในกลุ่มเรียน:</label>
                            <div class="col-md-8">
                                <div class="radio">
                                    <div class="col-md-2">
                                        <input type="radio" name="hide_examing" id="hide_ex" value="0" ng-model="hiddenMode">
                                        <label for="hide_ex">ซ่อน</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="hide_examing" id="show_ex" value="1" ng-model="hiddenMode">
                                        <label for="show_ex">แสดง</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--History Examing--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">เข้าถึงประวัติการสอบ:</label>
                            <div class="col-md-8">
                                <div class="radio">
                                    <div class="col-md-2">
                                        <input type="radio" name="hide_history" id="hide_his" value="0" ng-model="historyMode">
                                        <label for="hide_his">อนุญาต</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="hide_history" id="show_his" value="1" ng-model="historyMode">
                                        <label for="show_his">ไม่อนุญาต</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>

                        <!--Submit part -->
                        <div class = "form-group">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <input type="button" class="btn btn-outline-success btn-block" value="บันทึก" ng-click="okEditOpenExam()"/>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-outline-danger btn-block" ng-click="goBack()">ยกเลิก</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <b class="danger">*</b> จำเป็นต้องกรอกข้อมูล
                </div>
            </div>
        </div>
        <div id="dtBox"></div>
    </div>

    <script>
        $(document).ready(function () {
            $('[ng-model=userGroupId]').val(0);
            setDataTimePart();

            // จัดการติกข้อสอบที่เลือกไว้
            $('[id^=exam_]').each(function () {
                examID = $(this).attr('id').substr(5);
                $(exam_examing).each(function (k, v) {
                    if (parseInt(examID) === v.exam_id) {
                        $('#exam_' + examID).attr('checked', 'checked');
                        $('#exam_' + examID).parent().parent().children('div').show();
                        $('#exam_' + examID).parent().parent().children().children('.fa-plus-square').addClass('fa-minus-square');
                        $('#exam_' + examID).parent().parent().children().children('.fa-plus-square').removeClass('fa-plus-square');
                    }
                });

            });

            $('#editOpenExam_div').css('display','block');
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
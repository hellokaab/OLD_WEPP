@extends('layouts.template')
@section('content')
    <script src="js/Components/addExamCtrl.js"></script>
    <script>
        var groupId = {{$groupID}};
    </script>
    <div ng-controller="addExamCtrl">
        <div class="col-lg-12">
            <div class="panel panel-default" id="add_exam_part">
                <div class="panel-heading">
                    <b style="color: #555">เพิ่มข้อสอบ</b>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal" role="form">
                        {{--Exam Name--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">ชื่อข้อสอบ: <b class="danger">*</b></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" ng-model="examName" maxlength="30" autofocus/>
                                <div class="notice" id="notice_exam_name" style="display: none">กรุณาระบุชื่อข้อสอบ
                                </div>
                            </div>
                        </div>

                        {{--Exam Group--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">กลุ่มข้อสอบ: </label>
                            <div class="col-md-4">
                                <select class="form-control" id="ddl_group">
                                    <option style="display: none"></option>
                                    <option ng-repeat="g in mySection" value="<%g.id%>"><%g.section_name%></option>
                                </select>
                            </div>
                        </div>

                        {{--Exam Contents--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">รายละเอียด: <b class="danger">*</b></label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="exam_content"></textarea>
                                <div class="notice" id="notice_exam_content" style="display: none">
                                    กรุณาระบุรายละเอียดของข้อสอบ
                                </div>
                            </div>
                        </div>

                        {{--<!-- Input -->--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">Input:</label>
                            <div class="col-md-9">
                                <div class="radio">
                                    <div class="col-md-4">
                                        <input type="radio" name="input" id="keyInputChk" value="key_input"
                                               ng-model="inputMode" ng-click="changeInputMode()">
                                        <label for="keyInputChk">Keyboard input</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="input" id="txtInputChk" value="file_input"
                                               ng-model="inputMode" ng-click="changeInputMode()">
                                        <label for="txtInputChk">Text file</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="input" id="noInputChk" value="no_input"
                                               ng-model="inputMode" ng-click="changeInputMode()">
                                        <label for="noInputChk">ไม่มี Input</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" ng-show="inputMode == 'key_input'">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-9">
                                <textarea class="form-control io_textarea" ng-model="input" rows="5"
                                          placeholder="ใส่ Input ที่นี่"></textarea>
                                <div class="notice" id="notice_exam_txt_input" style="display: none">กรุณาระบุ Input
                                    ของข้อสอบ
                                </div>
                            </div>
                        </div>

                        <form id="inputFileForm" action="javascript:submitInputForm();" method="post" enctype = "multipart/form-data">
                            <div class="form-group" ng-show="inputMode == 'file_input'">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-4">
                                    <input type="file" class="inline-form-control" ng-bind="input"
                                           name="exam_file_input"
                                           accept=".txt">
                                    <div class="notice" id="notice_exam_file_input" style="display: none">กรุณาระบุไฟล์
                                        Input ของข้อสอบ
                                    </div>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </form>


                        {{--<!-- Output -->--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">Output: <b class="danger">*</b></label>
                            <div class="col-md-9">
                                <div class="radio">
                                    <div class="col-md-4">
                                        <input type="radio" name="output" id="keyOutputChk" value="key_output"
                                               ng-model="outputMode" ng-click="changeOutputMode()">
                                        <label for="keyOutputChk">Keyboard output</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="output" id="txtOutputChk" value="file_output"
                                               ng-model="outputMode" ng-click="changeOutputMode()">
                                        <label for="txtOutputChk">Text file</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" ng-show="outputMode == 'key_output'">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-9">
                                <textarea class="form-control io_textarea" ng-model="output" rows="5"
                                          placeholder="ใส่ Output ที่นี่"></textarea>
                                <div class="notice" id="notice_exam_txt_output" style="display: none">กรุณาระบุ Output
                                    ของข้อสอบ
                                </div>
                            </div>
                        </div>

                        <form id="outputFileForm" action="javascript:submitOutputForm();" method="post" enctype = "multipart/form-data">
                            <div class="form-group" ng-show="outputMode == 'file_output'">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-4">
                                    <input type="file" class="inline-form-control"
                                           name="exam_file_output" accept=".txt">
                                    <div class="notice" id="notice_exam_file_output" style="display: none">กรุณาระบุไฟล์
                                        Output ของข้อสอบ
                                    </div>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </form>

                        {{--<!-- Main code -->--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">Class test:</label>
                            <div class="col-md-9">
                                <div class="radio">
                                    <div class="col-md-2">
                                        <input type="radio" name="classMode" id="has_main" value="1"
                                               ng-model="classTestMode" ng-click="changeClassTestMode()">
                                        <label for="has_main">ใช่</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" name="classMode" id="no_main" value="0"
                                               ng-model="classTestMode" ng-click="changeClassTestMode()">
                                        <label for="no_main">ไม่ใช่</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" ng-show="classTestMode == 1">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-9">
                                <textarea class="form-control io_textarea" ng-model="main" rows="10"
                                          placeholder="ใส่โค้ดเมธอด main ที่นี่"></textarea>
                                <div class="notice" id="notice_exam_main_input" style="display: none">กรุณาระบุข้อมูล
                                    Method main ของข้อสอบ
                                </div>
                            </div>
                        </div>

                        {{--<!-- Case sensitivity -->--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">Case sensitivity: </label>
                            <div class="col-md-9">
                                <div class="radio">
                                    <div class="col-md-2">
                                        <input type="radio" name="caseSensitive" id="case_sensitive" value="1"
                                               ng-model="casesensitive">
                                        <label for="case_sensitive">ใช่</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" name="caseSensitive" id="case_insensitive" value="0"
                                               ng-model="casesensitive">
                                        <label for="case_insensitive">ไม่ใช่</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--<!-- Keyword -->--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">Keyword:</label>
                            <div class="col-md-9">
                                <div id="keyword_part">
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control has-feedback" id="exam_keyword_1"
                                               maxlength="200" placeholder="เพิ่มคีย์เวิร์ด"/>
                                    </div>
                                </div>
                                <button id="add_keyword" class="btn btn-success btn-sm" style="display: none">
                                    <i class="fa fa-plus"></i> เพิ่มคีย์เวิร์ด
                                </button>
                            </div>
                        </div>
                        <br>

                        {{--<!-- Limit -->--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">ข้อจำกัด: <b class="danger">*</b></label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <label class="small">ขนาดหน่วยความจำ (KB)</label>
                                        <input type="text" class="form-control" ng-model="memLimit" id="mem_limit"
                                               ng-keyup="checkMemLimit()" maxlength="6"/>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <label class="small">เวลาในการประมวลผล (sec)</label>
                                        <input type="text" class="form-control" ng-model="timeLimit" id="time_limit"
                                               ng-keyup="checkTimeLimit()" maxlength="6"/>
                                    </div>
                                </div>
                                <div class="notice" id="notice_exam_limit" style="display: none">
                                    กรุณาระบุข้อมูลข้อจำกัดให้ครบถ้วนสมบูรณ์
                                </div>
                            </div>
                        </div>

                        {{--<!-- Score -->--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">การให้คะแนน: <b class="danger">*</b></label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <label class="small">คะแนนเต็ม</label>
                                        <input type="text" class="form-control" ng-model="fullScore" id="full_score"
                                               ng-keyup="checkFullScore()" maxlength="6"/>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <label class="small">คำตอบถูกบางส่วน (% ของคะแนนเต็ม)</label>
                                        <input type="text" class="form-control" ng-model="imperfectScore"
                                               id="imperfect_score"
                                               ng-keyup="checkImperfectScore()" maxlength="6"/>
                                    </div>
                                </div>
                                <div class="notice" id="notice_exam_score" style="display: none">
                                    กรุณาระบุข้อมูลการให้คะแนนให้ครบถ้วนสมบูรณ์
                                </div>
                            </div>
                        </div>

                        {{--<!-- Decrease Score -->--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">การหักคะแนน: <b class="danger">*</b></label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <label class="small">คำตอบผิดพลาด</label>
                                        <input type="text" class="form-control" ng-model="cutWrongAnswer"
                                               id="cut_wrong_ans"
                                               ng-keyup="checkCutWrongAnswer()" maxlength="6"/>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <label class="small">รูปแบบโค้ดไม่ถูกต้อง</label>
                                        <input type="text" class="form-control" ng-model="cutComplieError"
                                               id="cut_compile_err"
                                               ng-keyup="checkCutComplieError()" maxlength="6"/>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <label class="small">หน่วยความจำเกิน</label>
                                        <input type="text" class="form-control" ng-model="cutOverMem" id="cut_over_mem"
                                               ng-keyup="checkCutOverMem()" maxlength="6"/>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <label class="small">เวลาประมวณผลเกิน</label>
                                        <input type="text" class="form-control" ng-model="cutOverTime"
                                               id="cut_over_time"
                                               ng-keyup="checkCutOverTime()" maxlength="6"/>
                                    </div>
                                </div>
                                <div class="notice" id="notice_exam_descore" style="display: none">
                                    กรุณาระบุข้อมูลการหักคะแนนให้ครบถ้วนสมบูรณ์
                                </div>
                            </div>
                        </div>
                        <br>

                        {{--<!--Submit part -->--}}
                        <div class="form-group">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <input type="button" class="btn btn-success btn-block" ng-click="addExam()"
                                       value="เพิ่มข้อสอบ"/>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-danger btn-block" href="<%myUrl%>/exam">ยกเลิก</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="form-horizontal" role="form">--}}

                {{--<form name="form_io" id="form_io" action="Exams/upload.php" target="upload_iframe" method="post" enctype="multipart/form-data" accept-charset="utf-8">--}}


                {{--</form>--}}

            </div>
        </div>
    </div>
    <script>
        var input_part = "";
        var output_part = "";
        var $numberOnly = $("#time_limit,#cut_wrong_ans,#cut_compile_err,#cut_over_mem,#cut_over_time");
        var $numberNoDot = $("#full_score, #mem_limit");

        // -- Keyword
        _keyword_id = 1;
        $('#keyword_part').on('input', function () {
            keyword = $(this).children().children('#exam_keyword_' + _keyword_id).val();
            if (keyword.length > 0) {
                $('#add_keyword').show();
            } else {
                $('#add_keyword').hide();
            }
        });

        $('#add_keyword').click(function () {
            addFieldKeyword();
        });

        $('#keyword_part').keypress(function (e) {
            if (e.which === 13)
                addFieldKeyword();
        });

        function addFieldKeyword() {
            count = 1;
            $('[id^=exam_keyword_]').each(function () {
                if (this.value.length === 0)
                    $(this).parent().remove();
                else
                    count++;
            });

            if (count > 10) {
                alert('จำกัดคีย์เวิร์ดไว้ไม่เกิน 10 คีย์เวิร์ด');
            } else {
                _keyword_id++;
                $('#keyword_part').append('<div class="form-group has-feedback"><input type="text" class="form-control" id="exam_keyword_' + _keyword_id + '" placeholder="เพิ่มคีย์เวิร์ด" maxlength="200"/></div>');
                $('#add_keyword').hide();
                $('#exam_keyword_' + _keyword_id).focus();
            }
        }

        function submitInputForm() {
            var formData = new FormData($('#inputFileForum')[0]);
            input_part = $.ajax({
                url: url+'/uploadFile',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false
            }).responseJSON;
            return false;
        }

        function submitOutputForm() {
            var formData = new FormData($('#outputFileForum')[0]);
            output_part = $.ajax({
                url: url+'/uploadFile',
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    alert('posted')
                },
                cache: false,
                contentType: false,
                processData: false
            }).responseJSON;
            return false;
        }

        $numberOnly.keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything

                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }

        });

        $numberNoDot.keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [8, 9, 27, 13]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything

                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }

        });
    </script>

@endsection
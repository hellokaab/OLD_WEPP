@extends('layouts.template')

@section('content')
    <script src="js/Components/teacher/addWorksheetCtrl.js"></script>
    <script>
        var sheetGroupId = {{$sheetGroupId}};
    </script>
    <div ng-controller="addWorksheetCtrl">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="<%myUrl%>/index">หน้าหลัก</a></li>
                <li>คลังใบงาน</li>
                <li><a href="<%myUrl%>/myExam">กลุ่มใบงานของฉัน</a></li>
                <li class="active">เพิ่มใบงาน</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b style="color: #555">เพิ่มใบงาน</b>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal" role="form">

                        {{--sheetName--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">ชื่อใบงาน: <b class="danger">*</b></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" ng-model="sheetName" maxlength="30" autofocus/>
                                <div class="notice" id="notice_exam_name" style="display: none">กรุณาระบุชื่อใบงาน</div>
                            </div>
                        </div>

                        {{--sheet_group--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">กลุ่มใบงาน: </label>
                            <div class="col-md-4">
                                <select class="form-control" id="sheet_group">
                                    <option style="display: none"></option>
                                    <option ng-repeat="s in mySheetGroup" value="<%s.id%>"><%s.sheetName_group%></option>
                                </select>
                            </div>
                        </div>

                        {{--Objective--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">วัตถุประสงค์: <b class="danger">*</b></label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="sheet_objective" placeholder="ใส่จุดประสงค์ที่นี้" rows="5"></textarea>
                                <div class="notice" id="notice_sheet_content" style="display: none">
                                    กรุณาระบุวัตถุประสงค์ของใบงาน
                                </div>
                            </div>
                        </div>

                        {{--Theory--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">ทฤษฎีที่เกี่ยวข้อง: <b class="danger">*</b></label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="sheet_theory" placeholder="ใส่ทฤษฏีที่นี่" rows="5" ></textarea>
                                <div class="notice" id="notice_sheet_theory" style="display: none">
                                    กรุณาระบุทฤษฎีที่เกี่ยวข้อง
                                </div>
                            </div>
                        </div>

                        {{--Testing--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">การทดลอง: <b class="danger">*</b></label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="sheet_testing"></textarea>
                                <div class="notice" id="notice_sheet_testing" style="display: none">
                                    กรุณาระบุการทดลอง
                                </div>
                            </div>
                        </div>

                        {{--Input--}}
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
                                <div class="notice" id="notice_sheet_txt_input" style="display: none">กรุณาระบุ Input
                                    ของใบงาน
                                </div>
                            </div>
                        </div>

                        <form id="inputFileForm" action="javascript:submitInputForm();" method="post" enctype = "multipart/form-data">
                            <div class="form-group" ng-show="inputMode == 'file_input'">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-4">
                                    <input type="file" class="inline-form-control" ng-bind="input"
                                           name="sheet_file_input"
                                           accept=".txt">
                                    <div class="notice" id="notice_sheet_file_input" style="display: none">กรุณาระบุไฟล์
                                        Input ของใบงาน
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
                                <div class="notice" id="notice_sheet_txt_output" style="display: none">กรุณาระบุ Output
                                    ของใบงาน
                                </div>
                            </div>
                        </div>

                        <form id="outputFileForm" action="javascript:submitOutputForm();" method="post" enctype = "multipart/form-data">
                            <div class="form-group" ng-show="outputMode == 'file_output'">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-4">
                                    <input type="file" class="inline-form-control"
                                           name="sheet_file_output" accept=".txt">
                                    <div class="notice" id="notice_sheet_file_output" style="display: none">กรุณาระบุไฟล์
                                        Output ของใบงาน
                                    </div>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </form>

                        {{--sheet score--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">คะแนนการทดลอง:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" ng-model="sheetScore" maxlength="30" autofocus/>
                                <div class="notice" id="notice_sheet_score" style="display: none">กรุณาระบุคะแนนการทดลอง</div>
                            </div>
                            <label class="col-md-1 control-label">หมายเหตุ: </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" ng-model="sheetNotation" maxlength="30" autofocus/>
                                <div class="notice" id="notice_sheet_notation" style="display: none">กรุณาระบุหมายเหตุ</div>
                            </div>
                        </div>

                        {{--Notation--}}
                        {{--<div class="form-group">--}}
                            {{--<label class="col-md-2 control-label">หมายเหตุ: </label>--}}
                            {{--<div class="col-md-4">--}}
                                {{--<input type="text" class="form-control" ng-model="sheetNotation" maxlength="30" autofocus/>--}}
                                {{--<div class="notice" id="notice_sheet_notation" style="display: none">กรุณาระบุหมายเหตุ</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<!--Submit part -->--}}
                        <br>
                        <div class="form-group">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <input type="button" class="btn btn-outline-success btn-block" ng-click="addWorksheet()"
                                       value="เพิ่มใบงาน"/>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-outline-danger btn-block" ng-click="goBack()">ยกเลิก</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
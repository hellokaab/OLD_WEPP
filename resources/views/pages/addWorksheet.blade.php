@extends('layouts.template')

@section('content')
    <script src="js/Components/addWorksheetCtrl.js"></script>
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
                            <div class="form-group">
                                <label class="col-md-2 control-label">ชื่อใบงาน: <b class="danger">*</b></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" ng-model="sheetName" maxlength="30" autofocus/>
                                    <div class="notice" id="notice_exam_name" style="display: none">กรุณาระบุชื่อใบงาน</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">กลุ่มใบงาน: </label>
                                <div class="col-md-4">
                                    <select class="form-control" id="sheet_group">
                                        <option style="display: none"></option>
                                        <option ng-repeat="s in mySheetGroup" value="<%s.id%>"><%s.sheetName_group%></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">วัตถุประสงค์: <b class="danger">*</b></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="sheet_objective"></textarea>
                                    <div class="notice" id="notice_sheet_content" style="display: none">
                                        กรุณาระบุวัตถุประสงค์ของใบงาน
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">ทฤษฎีที่เกี่ยวข้อง: <b class="danger">*</b></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="sheet_theory"></textarea>
                                    <div class="notice" id="notice_sheet_theory" style="display: none">
                                        กรุณาระบุทฤษฎีที่เกี่ยวข้อง
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">การทดลอง: <b class="danger">*</b></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="sheet_testing"></textarea>
                                    <div class="notice" id="notice_sheet_testing" style="display: none">
                                        กรุณาระบุการทดลอง
                                    </div>
                                </div>
                            </div>
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
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
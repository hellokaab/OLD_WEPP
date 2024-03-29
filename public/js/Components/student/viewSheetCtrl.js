app.controller('viewSheetCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.sheeting = $window.sheeting;
    $scope.inputMode = 'key_input';
    $scope.allowedFileType = $scope.sheeting.allowed_file_type.split(",");
    $scope.groupData = findGroupDataByID($scope.sheeting.group_id);
    $scope.sheetSheeting = findSheetSheetingInViewSheet($scope.sheeting.id,myuser.id);
    $(document).ready(function () {
        $scope.selectFileType = $scope.allowedFileType[0];
    });
    $('#sheet_trial').Editor();
    $scope.objective = "";
    $scope.theory = "";
    $scope.thisStatus = "";
    $scope.tab = "s";

    var checked = 0;
    var count = 0;
    $scope.resSheetID = 0;
    var send = false;
    //----------------------------------------------------------------------
    $scope.startSheet = function (data) {
        $scope.tab = "s";
        $scope.inputMode = 'key_input';
        $('#notice_sheet_key_ans').hide();
        $('#notice_sheet_file_ans').hide();
        $('#li_s').attr('class','active');
        $('#li_o').removeAttr('class');
        $('#fileType').removeAttr('disabled');
        $('#keyInputChk').removeAttr('disabled');
        $('#fileInputChk').removeAttr('disabled');
        $('[ng-model=codeSheet]').removeAttr('disabled');

        send = false;
        $scope.codeSheet = "";
        document.getElementById('file_ans').value = "";
        $scope.CurrentIndex = $scope.sheetSheeting.indexOf(data);
        $scope.thisSheet = data;
        $scope.sheetID = data.sheet_id;
        $scope.thisStatus = data.current_status;
        $scope.quiz = findQuizBySID(data.sheet_id);


        $('#detail_sheet_modal').modal({backdrop: 'static'});
        $('#detail_sheet_part').waitMe({
            effect: 'win8_linear',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        if($scope.thisStatus === 'a'){
            $('#fileType').attr('disabled','disabled');
            $('#keyInputChk').attr('disabled','disabled');
            $('#fileInputChk').attr('disabled','disabled');
            $('[ng-model=codeSheet]').attr('disabled','disabled');
        }
    };
    //----------------------------------------------------------------------
    $scope.okSend = function () {
        checked = 0;
        var result = "";
        if($scope.inputMode === 'key_input'){
            if($scope.codeSheet.length > 0){
                data = {
                    STID : $scope.sheeting.id,
                    SID : $scope.sheetID,
                    UID : $window.myuser.id,
                    code : $scope.codeSheet,
                    mode : "key",
                    send_date_time : dtJsToDtDB(new Date()),
                    send_late : checkSendLate()
                };
                // ถ้าเป็นไฟล์ .c
                if($scope.selectFileType === "c"){
                    sendSheetC(data);
                }

                // ถ้าเป็นไฟล์ .cpp
                else if($scope.selectFileType === "cpp"){
                    sendSheetCpp(data);
                }

                // ถ้าเป็นไฟล์ .java
                else if($scope.selectFileType === "java"){
                    sendSheetJava(data);
                }

                // ถ้าเป็นไฟล์ .cs
                else if($scope.selectFileType === "cs"){
                    sendSheetCs(data);
                }
                sendQuiz();
            } else {
                if($scope.thisStatus != 'a'){
                    $('#notice_sheet_key_ans').html('* กรุณาใส่โค้ดโปรแกรม').show();
                } else {
                    sendQuiz();
                    $('#detail_sheet_modal').modal('hide');
                }
            }
        } else {
            if($("#file_ans")[0].files.length > 0){
                checkFile = checkFileType($("#file_ans")[0].files);
                if(checkFile){
                    $window.sheetID = $scope.sheetID;
                    $('#AnsFileForm').submit();

                    data = {
                        path : $window.sheet_part,
                        STID : $scope.sheeting.id,
                        SID : $scope.sheetID,
                        UID : $window.myuser.id,
                        mode : "file",
                        send_date_time : dtJsToDtDB(new Date()),
                        send_late : checkSendLate()
                    };

                    // ถ้าเป็นไฟล์ .c
                    if($scope.selectFileType === "c"){
                        if(($("#file_ans")[0].files).length > 1){
                            $('#detail_sheet_part').waitMe('hide');
                            $('#err_message').html('ไม่อนุญาตให้ส่งไฟล์ .c มากกว่า 1 ไฟล์');
                            $('#fail_modal').modal('show');
                        } else {
                            sendSheetC(data);
                        }
                    }

                    // ถ้าเป็นไฟล์ .cpp
                    else if($scope.selectFileType === "cpp"){
                        if(($("#file_ans")[0].files).length > 1){
                            $('#detail_sheet_part').waitMe('hide');
                            $('#err_message').html('ไม่อนุญาตให้ส่งไฟล์ .cpp มากกว่า 1 ไฟล์');
                            $('#fail_modal').modal('show');
                        } else {
                            sendSheetCpp(data);
                        }
                    }

                    // ถ้าเป็นไฟล์ .java
                    else if($scope.selectFileType === "java"){
                        sendSheetJava(data);
                    }

                    // ถ้าเป็นไฟล์ .cs
                    else if($scope.selectFileType === "cs"){
                        sendSheetCs(data);
                    }
                    sendQuiz();
                } else {
                    $('#detail_sheet_part').waitMe('hide');
                    $('#err_message').html('ประเภทของไฟล์ที่คุณส่ง ไม่ตรงกับประเภทไฟล์ที่ระบุ');
                    $('#fail_modal').modal('show');
                }
            } else {
                $('#notice_sheet_file_ans').html('* กรุณาเลือกไฟล์').show();
            }
        }
    };
    //----------------------------------------------------------------------
    var entityMap = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': '&quot;',
        "'": '&#39;',
        "/": '&#x2F;'
    };

    function escapeHtml(string) {
        return String(string).replace(/[&<>"'\/]/g, function (s) {
            return entityMap[s];
        });
    }

    function decapeHtml(str) {
        str = str.replace(/&amp;/g, '&');
        str = str.replace(/&lt;/g, '<');
        str = str.replace(/&gt;/g, '>');
        str = str.replace(/&quot;/g, '"');
        str = str.replace(/&#39;/g, "'");
        str = str.replace(/&#x2F;/g, '/');
        return str;
    }
    //----------------------------------------------------------------------
    function getExtension(file) {
        var parts = file.name.split('.');
        return parts[parts.length - 1];
    }

    //----------------------------------------------------------------------
    function checkFileType(files) {
        for(i =0;i<files.length;i++){
            var ext = getExtension(files[i]);
            if (ext.toLowerCase() === $scope.selectFileType) {

            } else {
                return false;
            }
        }
        return true;
    }
    //----------------------------------------------------------------------
    function sendSheetJava(data) {
        var sendSheetJava = $.ajax({
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/sendSheetJava',
            data:JSON.stringify(data),
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        send = true;
                        $scope.sheetSheeting[$scope.CurrentIndex].current_status = 'Q';
                        // $scope.$apply();
                        $scope.resSheetID = xhr.responseJSON;
                        $('#detail_sheet_modal').modal('hide');
                    } else if (xhr.status == 209) {
                        $('#detail_sheet_modal').modal('hide');
                        $('#err_message').html('โค้ดที่ส่งไม่ใช่ Default package กรุณาแก้ไข package ของโค้ด');
                        $('#fail_modal').modal('show');
                    } else {
                        $('#detail_sheet_modal').modal('hide');
                        $('#unsuccess_modal').modal({backdrop: 'static'});
                    }
                }
            }
        }).responseJSON;
    }
    //----------------------------------------------------------------------
    function sendSheetC(data) {
        var sendSheetC = $.ajax({
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/sendSheetC',
            data:JSON.stringify(data),
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        send = true;
                        $scope.sheetSheeting[$scope.CurrentIndex].current_status = 'Q';
                        // $scope.$apply();
                        $scope.resSheetID = xhr.responseJSON;
                        $('#detail_sheet_modal').modal('hide');
                    } else if (xhr.status == 209) {
                        $('#detail_sheet_modal').modal('hide');
                        $('#err_message').html('โค้ดที่ส่งห้ามมี comment');
                        $('#fail_modal').modal('show');
                    } else {
                        $('#detail_sheet_modal').modal('hide');
                        $('#unsuccess_modal').modal({backdrop: 'static'});
                    }
                }
            }
        }).responseJSON;
        console.log(sendSheetC);
        return sendSheetC;
    }
    //----------------------------------------------------------------------
    function sendSheetCpp(data) {
        var sendSheetCpp = $.ajax({
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/cppSendSheet',
            data:JSON.stringify(data),
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        send = true;
                        $scope.sheetSheeting[$scope.CurrentIndex].current_status = 'Q';
                        // $scope.$apply();
                        $scope.resSheetID = xhr.responseJSON;
                        $('#detail_sheet_modal').modal('hide');
                    } else if (xhr.status == 209) {
                        $('#detail_sheet_modal').modal('hide');
                        $('#err_message').html('โค้ดที่ส่งห้ามมี comment');
                        $('#fail_modal').modal('show');
                    } else {
                        $('#detail_sheet_modal').modal('hide');
                        $('#unsuccess_modal').modal({backdrop: 'static'});
                    }
                }
            }
        }).responseJSON;
        return sendSheetCpp;
    }
    //----------------------------------------------------------------------
    function sendSheetCs(data) {
        var sendSheetCs = $.ajax({
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/csSendSheet',
            data:JSON.stringify(data),
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        send = true;
                        $scope.sheetSheeting[$scope.CurrentIndex].current_status = 'Q';
                        // $scope.$apply();
                        $scope.resSheetID = xhr.responseJSON;
                        $('#detail_sheet_modal').modal('hide');
                    } else if (xhr.status == 209) {
                        $('#detail_sheet_modal').modal('hide');
                        $('#err_message').html('โค้ดที่ส่งห้ามมี namespace');
                        $('#fail_modal').modal('show');
                    } else {
                        $('#detail_sheet_modal').modal('hide');
                        $('#unsuccess_modal').modal({backdrop: 'static'});
                    }
                }
            }
        }).responseJSON;
        return sendSheetCs;
    }
    //----------------------------------------------------------------------
    function dtJsToDtDB(date) {
        date = date.toLocaleString();
        dt = date.split(' ');
        d = dt[0].split('/');
        r = (d[2] - 543) + '-' + d[1] + '-' + d[0] + ' ' + dt[1];
        return r;
    }

    function dtPickerToDtJS(date) {
        dt = date.split(' ');
        d = dt[0].split('-');
        r = (d[2]) + '-' + d[1] + '-' + d[0] + 'T' + dt[1] + ':00Z';
        return r;
    }
    //----------------------------------------------------------------------
    $('#detail_sheet_modal').on('hidden.bs.modal', function(){
        checked = 0;
        if(send){
            checkOrderSh($scope.resSheetID);
        }
    });
    //----------------------------------------------------------------------
    $('#detail_sheet_modal').on('shown.bs.modal', function(){ // ฟังก์ชันนี้เป็นฟังก์ชันที่จะทำงานหลังจาก modal แสดงเสร็จเรียบร้อยแล้ว
        var sheetData = findWorksheetByID($scope.thisSheet.sheet_id);
        $('#sheet_name').html(sheetData.sheet_name);
        var readFile = readFileSh(sheetData);
        // var sheetTrial = readSheetTrial(sheetData);
        var listObjective = new Array();
        if(readFile.objective != ""){
            listObjective = readFile.objective.split("\n");
        }
        $scope.objective = listObjective;

        var listTheory = new Array();
        if(readFile.theory != ""){
            listTheory = readFile.theory.split("\n");
        }
        $scope.theory = listTheory;

        var sheetTrial = readFile.trial;
        $('#sheet_trial').Editor('setText', decapeHtml(sheetTrial));
        $('.Editor-editor').attr('contenteditable', false);
        $('[id^=menuBarDiv]').hide();
        $('[id^=statusbar]').hide();

        //ค้นหาข้อมูลใบงานที่เก่าที่ส่ง
        var resSheet = findOldCodeInResSheet($scope.thisSheet.sheeting_id,$scope.thisSheet.sheet_id,myuser.id);
        $scope.resSheetID = resSheet.resSheetID;
        var code = "";
        (resSheet.code).forEach(function(codes) {
            code+=codes;
        });
        $('#old_code').html(escapeHtml(code));
        $('mycode').each(function(i, block) {
            hljs.highlightBlock(block);
        });

        $scope.resQuiz = findResQuizByRSID($scope.resSheetID);
        ($scope.resQuiz).forEach(function(res) {
            $('#quizAns_'+res.quiz_id).val(res.quiz_ans);
            console.log(res.quiz_ans);
        });
        $('#detail_sheet_part').waitMe('hide');

    });
    //----------------------------------------------------------------------
    function checkOrderSh(pathSheetID) {
        $.ajax({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/checkQueueSh',
            data:{pathSheetID:pathSheetID},
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    // ถ้าตัวเองคือคนแรก
                    if (xhr.status == 200) {
                        $scope.sheetSheeting[$scope.CurrentIndex].current_status = 'P';
                        $scope.$apply();
                        checked = 1;
                        var fileType = xhr.responseJSON;
                        if(fileType === "c"){
                            compileAndRunC(pathSheetID);
                        }
                        else if(fileType === "cpp"){
                            compileAndRunCpp(pathSheetID);
                        }
                        else if(fileType === "java"){
                            compileAndRunJava(pathSheetID);
                        }
                        else if(fileType === "cs"){
                            compileAndRunCs(pathSheetID);
                        }
                    } else { // ถ้าไม่ใช่คนแรก
                        // รอตรวจนานเกิน 9 วินาที
                        if (count > 2) {
                            deleteFirstQueue();
                            count = 0;
                        }
                    }
                    count++;
                    if (!checked) {
                        setTimeout(function () {
                            checkOrderSh(pathSheetID);
                        }, 3000);
                    }
                }
            }
        });
    }
    //----------------------------------------------------------------------
    function compileAndRunJava(pathSheetID) {
        var testCompile = $.ajax({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/compileAndRunJava',
            data:{
                mode:"sheet",
                pathSheetID:pathSheetID,
                sheet_id : $scope.sheetID
            },
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        $scope.sheetSheeting[$scope.CurrentIndex].current_status = xhr.responseJSON;
                        $scope.$apply();
                        deleteFirstQueue();
                    }
                }
            }
        }).responseJSON;
        console.log(testCompile);
    }
    //----------------------------------------------------------------------
    function compileAndRunC(pathSheetID) {
        var testCompile = $.ajax({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/compileAndRunC',
            data:{
                mode:"sheet",
                pathSheetID:pathSheetID,
                sheet_id : $scope.sheetID
            },
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        $scope.sheetSheeting[$scope.CurrentIndex].current_status = xhr.responseJSON;
                        $scope.$apply();
                        deleteFirstQueue();
                    }
                }
            }
        }).responseJSON;
        console.log(testCompile);
    }
    //----------------------------------------------------------------------
    function compileAndRunCpp(pathSheetID) {
        var testCompile = $.ajax({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/cppCompileAndRun',
            data:{
                mode:"sheet",
                pathSheetID:pathSheetID,
                sheet_id : $scope.sheetID
            },
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        $scope.sheetSheeting[$scope.CurrentIndex].current_status = xhr.responseJSON;
                        $scope.$apply();
                        deleteFirstQueue();
                    }
                }
            }
        }).responseJSON;
        console.log(testCompile);
    }
    //----------------------------------------------------------------------
    function compileAndRunCs(pathSheetID) {
        var pathBat = $.ajax({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/createBatFile',
            data:{
                mode:"sheet",
                pathSheetID:pathSheetID,
                sheet_id : $scope.sheetID
            },
            async: false,
        }).responseJSON;
        console.log(pathBat);

        var testCompile = $.ajax({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/csCompileAndRun',
            data:{
                mode:"sheet",
                pathSheetID:pathSheetID,
                sheet_id : $scope.sheetID,
                pathBat : pathBat
            },
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        $scope.sheetSheeting[$scope.CurrentIndex].current_status = xhr.responseJSON;
                        $scope.$apply();
                        deleteFirstQueue();
                    }
                }
            }
        }).responseJSON;
        console.log(testCompile);
    }
    //----------------------------------------------------------------------
    function deleteFirstQueue() {
        $.ajax({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/deleteFirstQueueSh',
            async: false,
        })
    }
    //----------------------------------------------------------------------
    function checkSendLate() {
        var sendLate = 0;
        now = new Date();
        endTime = dtPickerToDtJS($scope.sheeting.end_date_time);
        endTime = new Date(endTime);
        endTime = new Date(endTime.valueOf()+ endTime.getTimezoneOffset() * 60000);

        if(now > endTime){
            sendLate = 1;
        }
        return sendLate;
    }
    //----------------------------------------------------------------------
    function sendQuiz() {
        $('[id^=quizAns_]').each(function() {
            var eid = $(this)[0].id;
            var Qid = eid.split('_')[1];
            console.log($(this).val());
            var testCompile = $.ajax({
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                headers: {
                    Accept: "application/json"
                },
                url: url + '/sendQuiz',
                data:{
                    quiz_id: Qid,
                    ressheet_id:$scope.resSheetID,
                    quiz_ans : $(this).val()
                },
                async: false,
            }).responseJSON;
        });
    }
}]);

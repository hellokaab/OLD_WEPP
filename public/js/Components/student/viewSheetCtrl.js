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

    var checked = 0;
    var count = 0;
    var pathSheetID = 0;
    var send = false;
    //----------------------------------------------------------------------
    $scope.startSheet = function (data) {
        console.log(data);
        send = false;
        $scope.codeSheet = "";
        document.getElementById('file_ans').value = "";
        $scope.CurrentIndex = $scope.sheetSheeting.indexOf(data);
        $scope.sheetID = data.sheet_id;
        $scope.thisStatus = data.current_status;
        $('#detail_sheet_modal').modal({backdrop: 'static'});
        $('#detail_sheet_part').waitMe({
            effect: 'win8_linear',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        var sheetData = findWorksheetByID(data.sheet_id);
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
        $('#detail_sheet_part').waitMe('hide');
    };
    //----------------------------------------------------------------------
    $scope.okSend = function () {
        send = true;
        checked = 0;
        var result = "";
        $('#notice_sheet_key_ans').hide();
        $('#notice_sheet_file_ans').hide();
        if($scope.inputMode === 'key_input'){
            if($scope.codeSheet.length > 0){
                data = {
                    STID : $scope.sheeting.id,
                    SID : $scope.sheetID,
                    UID : $window.myuser.id,
                    code : $scope.codeSheet,
                    mode : "key",
                    send_date_time : dtJsToDtDB(new Date())
                };
                // ถ้าเป็นไฟล์ .java
                if($scope.selectFileType === "java"){
                    sendSheetJava(data);
                }
            } else {
                $('#notice_sheet_key_ans').html('* กรุณาใส่โค้ดโปรแกรม').show();
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
                        send_date_time : dtJsToDtDB(new Date())
                    };

                    // ถ้าเป็นไฟล์ .java
                    if($scope.selectFileType === "java"){
                        sendSheetJava(data);
                    }
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
                        $scope.sheetSheeting[$scope.CurrentIndex].current_status = 'Q';
                        // $scope.$apply();
                        pathSheetID = xhr.responseJSON;
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
    function dtJsToDtDB(date) {
        date = date.toLocaleString();
        dt = date.split(' ');
        d = dt[0].split('/');
        r = (d[2] - 543) + '-' + d[1] + '-' + d[0] + ' ' + dt[1];
        return r;
    }
    //----------------------------------------------------------------------
    $('#detail_sheet_modal').on('hidden.bs.modal', function(){
        checked = 0;
        if(send){
            checkOrderSh(pathSheetID);
        }
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
                        // if(fileType === "c"){
                        //     compileAndRunC(pathSheetID);
                        // }
                        // else if(fileType === "cpp"){
                        //     compileAndRunCpp(pathSheetID);
                        // }
                        if(fileType === "java"){
                            compileAndRunJava(pathSheetID);
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
}]);

app.controller('inGroupCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.groupData = $window.groupData;
    $scope.selectRow = "10";
    $scope.examingComing = findSTDExamingItsComing($scope.groupData.id);
    $scope.examingEnding = findExamingItsEnding($scope.groupData.id);
    $scope.sheeting = findSTDSheetingByGroupID($scope.groupData.id);

    // เปลี่ยนเวลาแบบ Database เป็นเวลาแบบ Data Time Picker
    for (i = 0; i < $scope.examingComing.length; i++) {
        $scope.examingComing[i].start_date_time = dtDBToDtPicker($scope.examingComing[i].start_date_time);
        $scope.examingComing[i].end_date_time = dtDBToDtPicker($scope.examingComing[i].end_date_time);
    }
    for (i = 0; i < $scope.examingEnding.length; i++) {
        $scope.examingEnding[i].start_date_time = dtDBToDtPicker($scope.examingEnding[i].start_date_time);
        $scope.examingEnding[i].end_date_time = dtDBToDtPicker($scope.examingEnding[i].end_date_time);
    }
    for (i = 0; i < $scope.sheeting.length; i++) {
        $scope.sheeting[i].start_date_time = dtDBToDtPicker($scope.sheeting[i].start_date_time);
        $scope.sheeting[i].end_date_time = dtDBToDtPicker($scope.sheeting[i].end_date_time);
    }

    $(document).ready(function () {
        var currentDate = new Date();
        for (i = 0; i < $scope.examingComing.length; i++) {
            console.log($scope.examingComing[i].start_date_time);
            var examingDate = new Date(dtPickerToDtJS($scope.examingComing[i].start_date_time));
            examingDate = new Date(examingDate.valueOf()+ examingDate.getTimezoneOffset() * 60000);
            if(currentDate > examingDate){
                $('#btn_examing_'+$scope.examingComing[i].id).attr('style','visibility: show');
            }
        }
    });
    //----------------------------------------------------------------------
    $scope.exitGroup = function () {
        $scope.groupName = $scope.groupData.group_name;
        $('#exit_group_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okExit = function () {
        $('#exit_group_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        exitGroup($window.myuser.id,$scope.groupData.id);
    };
    //----------------------------------------------------------------------
    $scope.admitExaming = function (data) {
        $scope.examing = data;
        $scope.examingPassword = "";
        $('#admit_modal').modal({backdrop: 'static'});
        $('#examing_password').focus();
        console.log($scope.examing);
    };
    //----------------------------------------------------------------------
    $scope.admitSheeting = function (data) {
        window.location.href = url+'/viewSheet'+data.id;
    };
    //----------------------------------------------------------------------
    $scope.okAdmitExaming = function () {
        if($scope.examingPassword === $scope.examing.examing_pass){
            if($scope.examing.ip_group === ""){
                checkRandomExam($scope.examing);
                window.location.href = url+'/viewExam'+$scope.examing.id;
            } else {
                var in_network = $.ajax({
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    headers: {
                        Accept: "application/json"
                    },
                    url:url + '/checkIP',
                    data: $scope.examing,
                    async: false,
                }).responseJSON;
                if(in_network){
                    checkRandomExam($scope.examing);
                    window.location.href = url+'/viewExam'+$scope.examing.id;
                } else {
                    $('#admit_modal').modal('hide');
                    $('#network_fail_modal').modal({backdrop: 'static'});
                }
            }

        } else {
            $('#admit_modal').modal('hide');
            $('#fail_modal').modal({backdrop: 'static'});
        }
    };
    //----------------------------------------------------------------------
    function dtDBToDtPicker(date) {
        dt = date.split(' ');
        d = dt[0].split('-');
        r = (d[2]) + '-' + d[1] + '-' + d[0] + ' ' + dt[1];
        return r.substring(0, 16);
    }

    function dtPickerToDtJS(date) {
        dt = date.split(' ');
        d = dt[0].split('-');
        r = (d[2]) + '-' + d[1] + '-' + d[0] + 'T' + dt[1] + ':00Z';
        return r;
    }

    function dtDBToDtJs(date) {
        dt = date.split(' ');
        d = dt[0].split('-');
        jsDt = d[1] + '/' + d[2] + '/' + d[0] + ' ' + dt[1];
        return jsDt;
    }
    //----------------------------------------------------------------------
    function checkRandomExam(examing) {
        if(examing.examing_mode === 'r'){
            var randomExam = findExamRandomByUID(myuser.id,examing.id);
            if(randomExam.length == 0){
                var examExaming = findExamExamingByExamingID(examing.id);
                console.log(examExaming);
                var randoms = [];
                for(i = 0 ; i < examing.amount ; i++){
                    var randomNum;
                    do{
                        var randomNum = Math.floor((Math.random() * examExaming.length));
                        var duplicate = false;
                        for(j = 0 ; j < randoms.length ; j++){
                            if(randoms[j] === randomNum){
                                duplicate = true;
                            }
                        }
                    }while(duplicate);
                    randoms.push(randomNum);
                }
                for(i = 0 ; i < randoms.length ; i++){
                    var num = randoms[i];
                    data = {
                        examing_id : examing.id,
                        user_id : myuser.id,
                        exam_id : examExaming[num].exam_id,
                    };
                    console.log(data);
                    addRandomExam(data);
                }
            }
        }
    }
    //----------------------------------------------------------------------
    $scope.checkInTime = function (data) {
        var inTime = false;
        now = new Date();
        startTime = dtPickerToDtJS(data.start_date_time);
        startTime = new Date(startTime);
        startTime = new Date(startTime.valueOf()+ startTime.getTimezoneOffset() * 60000);
        endTime = dtPickerToDtJS(data.end_date_time);
        endTime = new Date(endTime);
        endTime = new Date(endTime.valueOf()+ endTime.getTimezoneOffset() * 60000);

        if(now >= startTime && now <= endTime){
            inTime = true;
        }
        return inTime;
    };
    //----------------------------------------------------------------------
    $scope.checkSendLate = function (data) {
        var sendLate = false;
        if(data.send_late ==='1'){
            sendLate = true;
        }
        return sendLate;
    };
}]);
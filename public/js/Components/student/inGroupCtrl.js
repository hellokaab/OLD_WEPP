app.controller('inGroupCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.groupData = $window.groupData;
    $scope.selectRow = "10";
    $scope.examingComing = findSTDExamingItsComing($scope.groupData.id);
    $scope.examingEnding = findExamingItsEnding($scope.groupData.id);

    // เปลี่ยนเวลาแบบ Database เป็นเวลาแบบ Data Time Picker
    for (i = 0; i < $scope.examingComing.length; i++) {
        $scope.examingComing[i].start_date_time = dtDBToDtPicker($scope.examingComing[i].start_date_time);
        $scope.examingComing[i].end_date_time = dtDBToDtPicker($scope.examingComing[i].end_date_time);
    }
    for (i = 0; i < $scope.examingEnding.length; i++) {
        $scope.examingEnding[i].start_date_time = dtDBToDtPicker($scope.examingEnding[i].start_date_time);
        $scope.examingEnding[i].end_date_time = dtDBToDtPicker($scope.examingEnding[i].end_date_time);
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
        console.log($scope.examing);
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
        console.log(r);
        return r;
    }
    //----------------------------------------------------------------------
    function checkRandomExam(examing) {
        if(examing.examing_mode === 'r'){
            var randomExam = findExamRandomByUID(myuser.id);
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
                console.log(randoms);
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
}]);
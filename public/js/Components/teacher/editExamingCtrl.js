/**
 * Created by Pongpan on 27-Jul-17.
 */
app.controller('editOpenExamingCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.myGroups = $window.myGroup;
    $scope.sections = $window.sections;
    $scope.exams = $window.exams;
    $scope.thisUser = $window.myuser;
    $scope.examing = findExamingByID($window.examingID);
    $scope.examExamings = $window.exam_examing;

    // Initial values of this examing
    $scope.openExamName = $scope.examing.examing_name;
    $scope.userGroupId = $scope.examing.group_id;
    $scope.examingMode = $scope.examing.examing_mode;
    $scope.examingPassword = $scope.examing.examing_pass;
    $scope.ipMode = $scope.examing.ip_group.length > 0 ? '1' : '0';
    $scope.gatewayIp = '';
    $scope.subnetmask = '/32';
    $scope.allowNetwork = $scope.examing.ip_group;
    $scope.hiddenMode = $scope.examing.hide_examing;
    $scope.historyMode = $scope.examing.hide_history;

    $scope.selectExam = [];
    for (i = 0; i < $scope.examExamings.length; i++)
        $scope.selectExam.push($scope.examExamings[i].exam_id);

    $scope.randomExam = [];
    for (i = 1; i <= $scope.examing.amount; i++)
        $scope.randomExam.push(i);
    $scope.amountExam = $scope.examing.amount;

    $('#examingBegin').val(dtDBToDtPicker($scope.examing.start_date_time));
    $('#examingEnd').val(dtDBToDtPicker($scope.examing.end_date_time));

    $(document).ready(function () {
        $('#group_id').val($scope.userGroupId);
    });
    var deleteExamExaming = new Array();
    //----------------------------------------------------------------------
    $scope.ticExam = function () {
        $scope.selectExam = [];
        $scope.randomExam = [];
        i = 1;
        $('[id^=exam_]').each(function () {
            if ($(this).prop('checked')) {
                $scope.selectExam.push(parseInt($(this).attr('id').substr(5)));
                $scope.randomExam.push(i++);
            }
        });
    };
    //----------------------------------------------------------------------
    $scope.viewExam = function (examGroupId) {
        if ($('#group_' + examGroupId).hasClass('fa-plus-square')) {
            $('#group_' + examGroupId).removeClass('fa-plus-square');
            $('#group_' + examGroupId).addClass('fa-minus-square');
            $('#group_' + examGroupId).parent().parent().children('div').show();
        } else {
            $('#group_' + examGroupId).removeClass('fa-minus-square');
            $('#group_' + examGroupId).addClass('fa-plus-square');
            $('#group_' + examGroupId).parent().parent().children('div').hide();
        }
    };
    //----------------------------------------------------------------------
    $scope.ticAllInSec = function (SID) {
        $scope.exams.forEach(function(exam) {
            if(exam.section_id === SID){
                if($('#sec_'+SID)[0].checked){
                    $('#exam_'+exam.id)[0].checked = true;
                } else {
                    $('#exam_'+exam.id)[0].checked = false;
                }
            }
        });
        $scope.ticExam();
    };

    //----------------------------------------------------------------------
    $scope.randomPassword = function () {
        $scope.examingPassword = Math.floor(Math.random() * 9000) + 1000;
    };

    //----------------------------------------------------------------------
    $scope.addNetwork = function () {
            $scope.allowNetwork = $scope.allowNetwork.length === 0 ? $scope.allowNetwork : $scope.allowNetwork + '\n';
            $scope.allowNetwork = $scope.allowNetwork + $scope.gatewayIp;
            $scope.gatewayIp = '';
    };
    //----------------------------------------------------------------------
    $scope.clearIP = function () {
        $scope.allowNetwork = '';
    };

    //----------------------------------------------------------------------
    $scope.goBack = function () {
        window.history.back();
    }
    //----------------------------------------------------------------------
    $scope.okEditOpenExam = function () {
        $('#notice_gateway_ip').hide();
        $('#notice_examing_time').hide();
        $('#notice_examing_begin').hide();
        $('#notice_exam').hide();
        $('#notice_examing_usr_grp').hide();
        $('#notice_examing_name').hide();
        console.log($scope.openExamName != $scope.examing.examing_name);
        completeExamName = $scope.openExamName.length > 0;
        completeUserGroup = $scope.userGroupId > 0;
        completeNoDuplicate = true;
        if(completeExamName){
            if ($scope.openExamName != $scope.examing.examing_name){
                completeNoDuplicate = findExamingByNameAndGroup($scope.openExamName,$scope.userGroupId);
            }

        }
        completeExam = $scope.selectExam.length > 0;
        completeExamingBegin = $('#examingBegin').val().length > 0;
        completeExamingEnd = $('#examingEnd').val().length > 0;

        completeAllowNetwork = $scope.allowNetwork.length > 0;
        completeIP = $scope.ipMode === '0' ? true : (completeAllowNetwork ? true : false);

        if (completeExamName && completeUserGroup && completeExam && completeExamingBegin && completeExamingEnd && completeIP && completeNoDuplicate) {

            dateBegin = new Date(dtPickerToDtJs($('#examingBegin').val()));
            dateEnd = new Date(dtPickerToDtJs($('#examingEnd').val()));

            $('#edit_examing_part').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });

            console.log($scope.examExamings);
            for(i=0;i<$scope.examExamings.length;i++){
                var EID = $scope.examExamings[i].exam_id;
                var indexOfStevie = $scope.selectExam.indexOf(EID);
                if(indexOfStevie == -1){
                    deleteExamExaming.push(EID)
                }
            }

            data = {
                id: $scope.examing.id,
                examing_name: $scope.openExamName,
                group_id: $scope.userGroupId,
                exam: $scope.selectExam,
                examing_mode: $scope.examingMode,
                amount: $scope.examingMode === 'n' ? $scope.selectExam.length : $scope.amountExam,
                start_date_time: dtJsToDtDB(dateBegin),
                end_date_time: dtJsToDtDB(dateEnd),
                examing_pass: $scope.examingPassword,
                ip_group: $scope.allowNetwork,
                deleteExamExaming:deleteExamExaming,
                hide_examing : $scope.hiddenMode,
                hide_history : $scope.historyMode,
            }
            updateExaming(data);
        } else {
            if (!completeIP) {
                $('#notice_gateway_ip').html('* กรุณาระบุเครือข่ายที่อนุณาตให้ทำข้อสอบ').show();
                $('[ng-model=gatewayIp]').focus();
            }
            if (!completeExamingEnd) {
                $('#notice_examing_end').html('* กรุณาระบุเวลาสิ้นสุดการสอบ').show();
            }
            if (!completeExamingBegin) {
                $('#notice_examing_begin').html('* กรุณาระบุเวลาเริ่มสอบ').show();
            }
            if (!completeExam) {
                $('#notice_exam').html('* กรุณาระบุข้อสอบที่ใช้ในการสอบ').show();
                $('[ng-model=userGroupId]').focus();
            }
            if (!completeUserGroup) {
                $('#notice_examing_usr_grp').html('* กรุณาระบุกลุ่มเรียน').show();
                $('[ng-model=userGroupId]').focus();
            }
            if (!completeExamName) {
                $('#notice_examing_name').html('* กรุณาระบุชื่อการสอบ').show();
                $('[ng-model=openExamName]').focus();
            }

            if (!completeNoDuplicate) {
                $('#notice_examing_name').html('* มีการสอบนี้ในกลุ่มเรียนที่เลือกแล้ว').show();
                $('[ng-model=openExamName]').focus();
            }
        }
    };
    //----------------------------------------------------------------------
    function dtPickerToDtJs(date) {
        dt = date.split(' ');
        d = dt[0].split('-');
        jsDt = d[1] + '/' + d[0] + '/' + d[2] + ' ' + dt[1];
        return jsDt;
    }
    function dtJsToDtDB(date) {
        date = date.toLocaleString();
        dt = date.split(' ');
        d = dt[0].split('/');
        r = (d[2] - 543) + '-' + d[1] + '-' + d[0] + ' ' + dt[1];
        return r;
    }

    function dtDBToDtPicker(date) {
        dt = date.split(' ');
        d = dt[0].split('-');
        r = (d[2]) + '-' + d[1] + '-' + d[0] + ' ' + dt[1];
        return r.substring(0, 16);
    }
    //----------------------------------------------------------------------
    $('#okSuccess').on('click',function () {
        window.location.href = url+'/examingHistory';
    });
}]);
app.controller('openExamCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.myGroups = $window.myGroup;
    $scope.sections = $window.sections;
    $scope.exams = $window.exams;
    $scope.thisUser = $window.myuser;
    // $scope.teacherId = $window.user_id;

    // Set Default
    $scope.openExamName = '';
    $scope.userGroupId = '0';
    $scope.createrId = '0';
    $scope.examingMode = 'n';
    $scope.examingPassword = '';
    $scope.ipMode = '0';
    $scope.gatewayIp = '';
    $scope.subnetmask = '/32';
    $scope.allowNetwork = '';
    $scope.hiddenMode = '0';
    $scope.historyMode = '0';

    $scope.selectExam = [];
    $scope.randomExam = [];

    //----------------------------------------------------------------------
    $scope.ticExam = function () {
        $scope.selectExam = [];
        $scope.randomExam = [];
        i = 1;
        $('[id^=exam_]').each(function () {
            if ($(this).prop('checked')) {
                $scope.selectExam.push($(this).attr('id').substr(5));
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
    $scope.randomPassword = function () {
        $scope.examingPassword = Math.floor(Math.random() * 9000) + 1000;
    };

    //----------------------------------------------------------------------
    $scope.addNetwork = function () {
        $('#notice_gateway_ip').html('* กรุณาระบุไอพี Gateway ให้ถูกต้อง').show();
        if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test($scope.gatewayIp)) {
            $scope.allowNetwork = $scope.allowNetwork.length === 0 ? $scope.allowNetwork : $scope.allowNetwork + '\n';
            $scope.allowNetwork = $scope.allowNetwork + $scope.gatewayIp + $scope.subnetmask;
            $scope.gatewayIp = '';
            $('#notice_gateway_ip').hide();
        }
    };
    //----------------------------------------------------------------------
    $scope.clearIP = function () {
        $scope.allowNetwork = '';
    };

    //----------------------------------------------------------------------
    $scope.openExam = function () {
        $('#notice_gateway_ip').hide();
        $('#notice_examing_time').hide();
        $('#notice_examing_begin').hide();
        $('#notice_examing_end').hide();
        $('#notice_exam').hide();
        $('#notice_examing_usr_grp').hide();
        $('#notice_examing_name').hide();

        completeExamName = $scope.openExamName.length > 0;
        completeUserGroup = $scope.userGroupId > 0;
        completeNoDuplicate = true;
        if(completeExamName){
            completeNoDuplicate = findExamingByNameAndGroup($scope.openExamName,$scope.userGroupId);
        }
        completeExam = $scope.selectExam.length > 0;
        completeExamingBegin = $('#examingBegin').val().length > 0;
        completeExamingEnd = $('#examingEnd').val().length > 0;

        completeAllowNetwork = $scope.allowNetwork.length > 0;
        completeIP = $scope.ipMode === '0' ? true : (completeAllowNetwork ? true : false);

        if (completeExamName && completeUserGroup && completeExam && completeExamingBegin && completeExamingEnd && completeIP && completeNoDuplicate) {

            dateBegin = new Date(dtPickerToDtJs($('#examingBegin').val()));
            dateEnd = new Date(dtPickerToDtJs($('#examingEnd').val()));

            $('#open_exam_part').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });

            data = {
                user_id: $window.myuser.id,
                examing_name: $scope.openExamName,
                group_id: $scope.userGroupId,
                exam: $scope.selectExam,
                examing_mode: $scope.examingMode,
                amount: $scope.examingMode === 'n' ? $scope.selectExam.length : $scope.amountExam,
                start_date_time: dtJsToDtDB(dateBegin),
                end_date_time: dtJsToDtDB(dateEnd),
                examing_pass: $scope.examingPassword,
                ip_group: $scope.allowNetwork,
                hide_examing : $scope.hiddenMode,
                hide_history : $scope.historyMode,
            }
            createExaming(data);
            
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
    //----------------------------------------------------------------------
    $scope.goBack = function () {
        window.history.back();
    }

}]);



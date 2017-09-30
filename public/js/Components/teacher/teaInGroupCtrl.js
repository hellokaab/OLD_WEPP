/**
 * Created by Pongpan on 21-Aug-17.
 */
app.controller('teaInGroupCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.groupData = $window.groupData;
    $scope.thisUser = $window.myuser;
    console.log($scope.groupData);
    $scope.examingComing = findExamingItsComing($scope.groupData.id);
    $scope.examingEnding = findExamingItsEnding($scope.groupData.id);
    $scope.selectRow = "10";
    $scope.memberList = findMemberGroup($scope.groupData.id);
    console.log($scope.memberList);

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
        for(i=0;i<$scope.examingComing.length;i++){
            if($scope.examingComing[i].hide_examing === "0"){
                document.getElementById("hide_ex_"+$scope.examingComing[i].id).checked = true;
            } else {
                document.getElementById("show_ex_"+$scope.examingComing[i].id).checked = true;
            }
        }

        for(i=0;i<$scope.examingEnding.length;i++){
            if($scope.examingEnding[i].hide_history === "0"){
                document.getElementById("hide_hi_"+$scope.examingEnding[i].id).checked = true;
            } else {
                document.getElementById("show_hi_"+$scope.examingEnding[i].id).checked = true;
            }
        }
    });
    //----------------------------------------------------------------------
    $scope.editExaming = function (data) {
        window.location.href = url+"/editOpenExam"+data.id;
    };
    //----------------------------------------------------------------------
    $scope.deleteExaming = function (data) {
        $scope.examingName = data.examing_name;
        $scope.examingId = data.id;
        $('#delete_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okDeleteExaming = function () {
        $('#deleteExamingPart').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        deleteExaming($scope.examingId);
    };
    //----------------------------------------------------------------------
    $scope.openExaming = function() {
       window.location.href = url+"/openExam";
    };
    //----------------------------------------------------------------------
    $scope.changeToHidden = function(data) {
        $scope.examingName = data.examing_name;
        $scope.examingID = data.id;
        $('#change_hidden_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okHidden = function() {
        var data = {
            id        : $scope.examingID,
            hide_examing: "0",
        };

        $('#change_hidden_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });

        $.ajax ({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/changeHiddenExaming',
            data: data,
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        $('#change_hidden_part').waitMe('hide');
                        $('#change_hidden_modal').modal('hide');
                        $('#success_modal').modal({backdrop: 'static'});
                    } else {
                        $('#change_hidden_part').waitMe('hide');
                        $('#change_hidden_modal').modal('hide');
                        $('#unsuccess_modal').modal({backdrop: 'static'});
                    }
                }
            }
        });
    };
    //----------------------------------------------------------------------
    $scope.cancelHidden = function() {
        document.getElementById("show_ex_"+$scope.examingID).checked = true;
        $('#change_hidden_modal').modal('hide');
    };
    //----------------------------------------------------------------------
    $scope.changeToShow = function(data) {
        $scope.examingName = data.examing_name;
        $scope.examingID = data.id;
        $('#change_show_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okShow = function() {
        var data = {
            id        : $scope.examingID,
            hide_examing: "1",
        };

        $('#change_show_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });

        $.ajax ({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/changeHiddenExaming',
            data: data,
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        $('#change_show_part').waitMe('hide');
                        $('#change_show_modal').modal('hide');
                        $('#success_modal').modal({backdrop: 'static'});
                    } else {
                        $('#change_show_part').waitMe('hide');
                        $('#change_show_modal').modal('hide');
                        $('#unsuccess_modal').modal({backdrop: 'static'});
                    }
                }
            }
        });
    };
    //----------------------------------------------------------------------
    $scope.cancelShow = function() {
        document.getElementById("hide_ex_"+$scope.examingID).checked = true;
        $('#change_show_modal').modal('hide');
    };
    //----------------------------------------------------------------------
    $scope.changeToAllow = function(data) {
        $scope.examingName = data.examing_name;
        $scope.examingID = data.id;
        $('#change_allow_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okAllow = function() {
        var data = {
            id        : $scope.examingID,
            hide_history: "0",
        };

        $('#change_allow_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });

        $.ajax ({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/changeHistoryExaming',
            data: data,
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        $('#change_allow_part').waitMe('hide');
                        $('#change_allow_modal').modal('hide');
                        $('#success_modal').modal({backdrop: 'static'});
                    } else {
                        $('#change_allow_part').waitMe('hide');
                        $('#change_allow_modal').modal('hide');
                        $('#unsuccess_modal').modal({backdrop: 'static'});
                    }
                }
            }
        });
    };
    //----------------------------------------------------------------------
    $scope.cancelAllow = function() {
        document.getElementById("hide_hi_"+$scope.examingID).checked = true;
        $('#change_allow_modal').modal('hide');
    };
    //----------------------------------------------------------------------
    $scope.changeToDisallow = function(data) {
        $scope.examingName = data.examing_name;
        $scope.examingID = data.id;
        $('#change_disallow_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okDisallow = function() {
        var data = {
            id        : $scope.examingID,
            hide_history: "1",
        };

        $('#change_disallow_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });

        $.ajax ({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/changeHistoryExaming',
            data: data,
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        $('#change_disallow_part').waitMe('hide');
                        $('#change_disallow_modal').modal('hide');
                        $('#success_modal').modal({backdrop: 'static'});
                    } else {
                        $('#change_disallow_part').waitMe('hide');
                        $('#change_disallow_modal').modal('hide');
                        $('#unsuccess_modal').modal({backdrop: 'static'});
                    }
                }
            }
        });
    };
    //----------------------------------------------------------------------
    $scope.cancelDisallow = function() {
        document.getElementById("hide_hi_"+$scope.examingID).checked = true;
        $('#change_disallow_modal').modal('hide');
    };
    //----------------------------------------------------------------------
    $scope.enterEdit = function() {
        $('[ng-model=passwordGroup]').focus();
    };
    $scope.enterOkEdit = function() {
        $scope.okEditGroup();
    };
    //----------------------------------------------------------------------
    $scope.editGroup = function () {
        // $scope.CurrentIndex = $scope.groups.indexOf(data);
        $scope.groupName = $scope.groupData.group_name;
        $scope.passwordGroup = $scope.groupData.group_pass;

        $('#notice_name_edit_grp').hide();
        $('#notice_pass_edit_grp').hide();
        $('#edit_modal').modal({backdrop: 'static'});
        setTimeout(function () {
            $('[ng-model=groupName]').focus();
        }, 200);
    };
    //----------------------------------------------------------------------
    $scope.okEditGroup = function () {
        $('#notice_name_add_grp').hide();
        $('#notice_pass_add_grp').hide();

        if ($scope.groupName.length > 0 && $scope.passwordGroup.length > 3) {
            var dataGroup = {
                id        : $scope.groupData.id,
                group_name: $scope.groupName,
                pass_name : $scope.passwordGroup,
                user_id   :$scope.thisUser.id
            };
            console.log(dataGroup);
            $('#editGroupPart').waitMe({
                effect: 'win8_linear',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });
            var test = $.ajax ({
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                headers: {
                    Accept: "application/json"
                },
                url: url + '/Group/edit',
                data: dataGroup,
                async: false,
                complete: function (xhr) {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            $('#editGroupPart').waitMe('hide');
                            $('#edit_modal').modal('hide');
                            $('#success_modal').modal({backdrop: 'static'});
                            window.location.href = url+'/teaInGroup'+$scope.groupData.id;
                        } else if (xhr.status == 209){
                            $('#editGroupPart').waitMe('hide');
                            $('#notice_pass_edit_grp').html('* กลุ่มเรียนนี้มีอยู่แล้ว').show();
                            $('[ng-model=groupName]').focus();
                        } else {
                            $('#editGroupPart').waitMe('hide');
                            $('#edit_modal').modal('hide');
                            $('#unsuccess_modal').modal({backdrop: 'static'});
                        }
                    }
                }
            });
        } else if ($scope.groupName.length === 0) {
            $('#notice_name_edit_grp').html('* กรุณาระบุชื่อกลุ่มเรียน').show();
            $('[ng-model=groupName]').focus();
        } else if ($scope.passwordGroup.length < 4) {
            $('#notice_pass_edit_grp').html('* ต้องมีความยาวอย่างน้อย 4 ตัวอักษร').show();
            $('[ng-model=passwordGroup]').focus();
        }
    };
    //----------------------------------------------------------------------
    $scope.deleteMember = function (data) {
        $scope.memberName = data.fullName;
        $scope.memberId = data.user_id;
        $('#delete_member_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.showProfile = function (data) {
        $('#detail_modal').modal({backdrop: 'static'});
        $('#detail_part').waitMe({
            effect: 'win8_linear',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        var userProfile = findUserByID(data.user_id);
        $scope.prefix = userProfile.prefix;
        $scope.name = userProfile.fname_th+" "+userProfile.lname_th;
        $scope.email = userProfile.email;
        $scope.cardId = userProfile.stu_id;
        $scope.faculty = userProfile.faculty;
        $scope.department = userProfile.department;
        $('#detail_part').waitMe('hide');

    };
    //----------------------------------------------------------------------
    $scope.okDeleteMember = function () {
        var data = {
            group_id :$scope.groupData.id,
            user_id   :$scope.memberId,
        };

        $('#delete_member_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });

        $.ajax ({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/exitGroup',
            data: data,
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        $('#delete_member_part').waitMe('hide');
                        $('#delete_member_modal').modal('hide');
                        $scope.memberList = findMemberGroup($scope.groupData.id);
                        $('#success_modal').modal({backdrop: 'static'});
                    } else {
                        $('#delete_member_part').waitMe('hide');
                        $('#delete_member_modal').modal('hide');
                        $('#unsuccess_modal').modal({backdrop: 'static'});
                    }
                }
            }
        });
    };
    //----------------------------------------------------------------------
    // $('#okSuccess').on('click',function () {
    //     $('#success_modal').modal("hide");
    // });
    //----------------------------------------------------------------------
    function dtDBToDtPicker(date) {
        dt = date.split(' ');
        d = dt[0].split('-');
        r = (d[2]) + '-' + d[1] + '-' + d[0] + ' ' + dt[1];
        return r.substring(0, 16);
    }
}]);
app.controller('groupCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.students = $window.student_list;
    $scope.groups = $window.group_list;
    $scope.teacherId = $window.user_id;
    $scope.grouplist = $window.groupList;
    $scope.mygroup = $window.myGroupList;
    console.log($scope.mygroup);
    $scope.thisUser = $window.myuser;
    $scope.groupId = 0;
    $scope.queryBy = 'group_name';
    $scope.selectRow = '5';
    $scope.groupId = 0;
    $scope.sortS = 'group_name';
    $scope.sortC = 'group_admin';

    //----------------------------------------------------------------------
    $scope.changeGroup = function (data) {
        $scope.groupId = data.id;
        $('#listNameGroup').removeAttr('style');
    };
    //----------------------------------------------------------------------
    $scope.detail = function (data) {
        $scope.prefix = data.pre_name;
        $scope.name = data.fname + ' ' + data.lname;
        $scope.email = data.email;
        $scope.cardId = data.card_id.substr(0, 12) + '-' + data.card_id[12];
        $scope.faculty = data.fac_name;
        $scope.department = data.dep_name;
        $scope.userId = data.user_id;
        $scope.passwordGroup = data.user_pass;
        $('#detail_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.deleteGroup = function (data) {
        $scope.groupName = data.group_name;
        $scope.groupId = data.id;
        /*$scope.CurrentIndex = $scope.groups.indexOf(data);
         $scope.groupId = data.user_group_id;
         $scope.groupName = $scope.groups[$scope.CurrentIndex].group_name;*/
        $('#delete_grp_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okDelete = function () {
        $('#delete_user_part').waitMe({
            effect: 'win8_linear',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        $.post("../Process.php", {
            process: 'delete student',
            userStu: $scope.deleteUser
        }, function (data) {
            if (data === '1') {
                location.reload();
            } else {
                $('#delete_user_part').waitMe('hide');
                $('#delete_modal').modal('hide');
                $('#fail_modal').modal({backdrop: 'static'});
            }
        });
    };
    //----------------------------------------------------------------------
    $scope.delete = function (data) {
        $scope.name = data.pre_name + data.fname + ' ' + data.lname;
        $scope.deleteUser = data.user_id;
        $('#delete_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okDeleteGroup = function () {
        var dataGroup = {
            id : $scope.groupId,
        };
        $('#delete_group_part').waitMe({
            effect: 'win8_linear',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        deleteSectionGroup(dataGroup);
    };
    //----------------------------------------------------------------------
    $scope.enterAdd = function() {
        $('[ng-model=passwordGroup]').focus();
    };

    $scope.enterOkAdd = function() {
        $scope.okAddGroup();
    };

    //----------------------------------------------------------------------
    $scope.addGroup = function () {
        $scope.groupName = '';
        $scope.passwordGroup = '';
        $('#notice_name_add_grp').hide();
        $('#notice_pass_add_grp').hide();
        $('#add_modal').modal({backdrop: 'static'});
        setTimeout(function () {
            $('[ng-model=groupName]').focus();
        }, 200);
    };
    //----------------------------------------------------------------------
    $scope.okAddGroup = function () {
        $('#notice_name_add_grp').hide();
        $('#notice_pass_add_grp').hide();

        if ($scope.groupName.length > 0 && $scope.passwordGroup.length > 3) {
            console.log($scope.groupName);
            console.log($scope.passwordGroup);
            var dataGroup = {
                user_id : $window.myuser.id,
                group_name: $scope.groupName,
                pass_name : $scope.passwordGroup
            };
            $('#addGroupPart').waitMe({
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
                url: url + '/addGroup',
                data: dataGroup,
                async: false,
                complete: function (xhr) {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            $('#addGroupPart').waitMe('hide');
                            $('#add_modal').modal('hide');
                            $('#success_modal').modal({backdrop: 'static'});
                        } else if (xhr.status == 209){
                            $('#addGroupPart').waitMe('hide');
                            $('#notice_name_add_grp').html('* กลุ่มเรียนนี้มีอยู่แล้ว').show();
                            $('[ng-model=groupName]').focus();
                        } else {
                            $('#addGroupPart').waitMe('hide');
                            $('#add_modal').modal('hide');
                            $('#unsuccess_modal').modal({backdrop: 'static'});
                        }
                    }
                }
            });
            console.log(test);
        } else if ($scope.groupName.length === 0) {
            $('#notice_name_add_grp').html('* กรุณาระบุชื่อกลุ่มเรียน').show();
            $('[ng-model=groupName]').focus();
        } else if ($scope.passwordGroup.length < 4) {
            $('#notice_pass_add_grp').html('* ต้องมีความยาวอย่างน้อย 4 ตัวอักษร').show();
            $('[ng-model=passwordGroup]').focus();
        }
    };

    //----------------------------------------------------------------------
    $scope.enterEdit = function() {
        $('[ng-model=passwordGroup]').focus();
    };
    $scope.enterOkEdit = function() {
        $scope.okEditGroup();
    };
    //----------------------------------------------------------------------
    $scope.editGroup = function (data) {
        // $scope.CurrentIndex = $scope.groups.indexOf(data);
        $scope.groupName = data.group_name;
        $scope.passwordGroup = data.group_pass;
        $scope.groupId = data.id;

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
                id        : $scope.groupId,
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
    $scope.changePlaceholder  = function (data) {
        if($scope.queryBy === 'group_name'){
            $('#txt_search')[0].placeholder = "ชื่อกลุ่มเรียน";
        } else if($scope.queryBy === 'group_admin'){
            $('#txt_search')[0].placeholder = "ผู้ดูแลกลุ่ม";
        }
    };
    //----------------------------------------------------------------------
    $scope.sort = function(keyname){
        $scope.sortKey = keyname;   //set the sortKey to the param passed
        if($scope.sortKey === 'group_name'){
            $scope.reverseS = !$scope.reverseS; //if true make it false and vice versa
            if($scope.sortS === 'group_name'){
                $scope.sortS = '-group_name';
            } else {
                $scope.sortS = 'group_name';
            }
        } else {
            $scope.reverseC = !$scope.reverseC; //if true make it false and vice versa
            if($scope.sortC === 'group_admin'){
                $scope.sortC = '-group_admin';
            } else {
                $scope.sortC = 'group_admin';
            }
        }
    };
    //----------------------------------------------------------------------
    $('#okSuccess').on('click',function () {
        window.location.href = url+'/group';
    });
    //----------------------------------------------------------------------

}]);



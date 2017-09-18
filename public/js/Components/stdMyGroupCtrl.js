app.controller('stdMyGroupCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.myJoinGroup = $window.myJoinGroup;
    $scope.queryBy = 'group_name';
    $scope.selectRow = '10';
    $scope.thisUser = $window.myuser;
    $scope.groupID = 0;

    //----------------------------------------------------------------------
    $scope.changePlaceholder  = function (section) {
        if($scope.queryBy === 'group_name'){
            $('#txt_search')[0].placeholder = "ชื่อกลุ่มเรียน";
        } else if($scope.queryBy === 'creater'){
            $('#txt_search')[0].placeholder = "ชื่อผู้ดูแลกลุ่มเรียน";
        }
    };
    //----------------------------------------------------------------------
    $scope.sort = function(keyname){
        $scope.sortKey = keyname;   //set the sortKey to the param passed
        if($scope.sortKey === 'group_name'){
            $scope.reverseG = !$scope.reverseG; //if true make it false and vice versa
            if($scope.sortG === 'group_name'){
                $scope.sortG = '-group_name';
            } else {
                $scope.sortG = 'group_name';
            }
        } else {
            $scope.reverseC = !$scope.reverseC; //if true make it false and vice versa
            if($scope.sortC === 'creater'){
                $scope.sortC = '-creater';
            } else {
                $scope.sortC = 'creater';
            }
        }
    };
    //----------------------------------------------------------------------
    $scope.exitGroup = function (group) {
        $scope.groupID = group.group_id;
        $scope.groupName = group.group_name;
        $('#exit_group_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okExit = function () {
        $('#exit_group_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        $.ajax({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url:url + '/exitGroup',
            data:{
                user_id:$scope.thisUser.id,
                group_id:$scope.groupID},
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        window.location.href = url+'/stdMyGroup';
                    }  else {
                        $('#exit_group_part').waitMe('hide');
                        alert("ผิดพลาด");
                    }
                }
            }
        });
    }
}]);
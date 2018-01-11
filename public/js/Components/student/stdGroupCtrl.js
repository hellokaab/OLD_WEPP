app.controller('stdGroupCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.allGroup = $window.allGroup;
    console.log($scope.allGroup);
    $scope.queryBy = 'group_name';
    $scope.selectRow = '10';
    $scope.thisUser = $window.myuser;
    $scope.groupID = 0;
    $scope.groupPASS = "";
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
    $scope.clickGroup = function (group) {
        console.log(group);
        if($scope.thisUser.id === group.user_id){
            window.location.href = url+"teaInGroup"+group.id;
        } else {
            $scope.groupID = group.id;
            $scope.groupPASS = group.group_pass;
            $scope.groupName = group.group_name;
            var checkJoin = checkJoinGroup($scope.thisUser.id,group.id);
            console.log(checkJoin);
            if(checkJoin){
                window.location.href = url+"/inGroup"+$scope.groupID;
            } else {
                $('#join_group_modal').modal({backdrop: 'static'});
            }
        }
    }
    //----------------------------------------------------------------------
    $scope.okJoinGroup = function (group) {
        $('#notice_pass_grp').hide();
        if($scope.groupPASS === $scope.joinPass){
            $('#join_group_part').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });

            var status = "";
            $scope.thisUser.user_type === 't' ? status = "a" : status = "s";

            createJoinGroup($scope.thisUser.id,$scope.groupID,status);
            window.location.href = url+"/inGroup"+$scope.groupID;
        } else {
            $('#notice_pass_grp').html('* รหัสผ่านไม่ถูกต้อง').show();
            $('[ng-model=joinPass]').focus();
        }
    }
}]);
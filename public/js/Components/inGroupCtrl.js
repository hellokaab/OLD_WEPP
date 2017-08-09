/**
 * Created by Pongpan on 08-Aug-17.
 */
app.controller('inGroupCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.groupData = $window.groupData;
    $scope.selectRow = "10";
    $scope.memberList = findMemberGroup($scope.groupData.id);
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
    }
}]);
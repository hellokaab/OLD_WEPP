/**
 * Created by Pongpan on 08-Aug-17.
 */
app.controller('inGroupCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.groupData = $window.groupData;
    $scope.selectRow = "10";
    $scope.memberList = findMemberGroup($scope.groupData.id);
    $scope.examingComing = findSTDExamingItsComing($scope.groupData.id);
    console.log($scope.examingComing);

    // // เปลี่ยนเวลาแบบ Database เป็นเวลาแบบ Data Time Picker
    // for (i = 0; i < $scope.examingComing.length; i++) {
    //     $scope.examingComing[i].start_date_time = dtDBToDtPicker($scope.examings[i].start_date_time);
    //     $scope.examingComing[i].end_date_time = dtDBToDtPicker($scope.examings[i].end_date_time);
    // }
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
    //----------------------------------------------------------------------
    function dtDBToDtPicker(date) {
        dt = date.split(' ');
        d = dt[0].split('-');
        r = (d[2]) + '-' + d[1] + '-' + d[0] + ' ' + dt[1];
        return r.substring(0, 16);
    }
}]);
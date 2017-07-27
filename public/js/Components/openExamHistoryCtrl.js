/**
 * Created by Pongpan on 25-Jul-17.
 */
app.controller('openExamHistoryCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.groups = $window.myGroup;
    $scope.examings = $window.myExaming;

    // Set Default
    $scope.groupId = "0";
    $scope.selectRow = "10";
    // เปลี่ยนเวลาแบบ Database เป็นเวลาแบบ Data Time Picker
    for (i = 0; i < $scope.examings.length; i++) {
        $scope.examings[i].start_date_time = dtDBToDtPicker($scope.examings[i].start_date_time);
        $scope.examings[i].end_date_time = dtDBToDtPicker($scope.examings[i].end_date_time);
    }
    //----------------------------------------------------------------------
    $scope.deleteExaming = function (data) {
        $scope.examingName = data.examing_name;
        $scope.examingId = data.id;
        $('#delete_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okDeleteExaming = function () {
        $('#deleteExamingPart').waitMe({
            effect: 'win8_linear',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        deleteExaming($scope.examingId);
    };
    //----------------------------------------------------------------------
    function dtDBToDtPicker(date) {
        dt = date.split(' ');
        d = dt[0].split('-');
        r = (d[2]) + '-' + d[1] + '-' + d[0] + ' ' + dt[1];
        return r.substring(0, 16);
    }

}]);
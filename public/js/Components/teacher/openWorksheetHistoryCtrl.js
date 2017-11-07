app.controller('openWorksheetHistoryCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.groups = $window.myGroup;
    $scope.sheeting = $window.mySheeting;

    // Set Default
    $scope.groupId = "0";
    $scope.selectRow = "10";
    // เปลี่ยนเวลาแบบ Database เป็นเวลาแบบ Data Time Picker
    for (i = 0; i < $scope.sheeting.length; i++) {
        $scope.sheeting[i].start_date_time = dtDBToDtPicker($scope.sheeting[i].start_date_time);
        $scope.sheeting[i].end_date_time = dtDBToDtPicker($scope.sheeting[i].end_date_time);
    }
    //----------------------------------------------------------------------
    $scope.editSheeting = function (data) {
        window.location.href = url+"/editOpenSheet"+data.id;
    };
    //----------------------------------------------------------------------
    $scope.deleteSheeting = function (data) {
        $scope.sheetingName = data.sheeting_name;
        $scope.sheetingId = data.id;
        $('#delete_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okDeleteSheeting = function () {
        $('#delete_sheeting_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        deleteSheeting($scope.sheetingId);
    };
    //----------------------------------------------------------------------
    function dtDBToDtPicker(date) {
        dt = date.split(' ');
        d = dt[0].split('-');
        r = (d[2]) + '-' + d[1] + '-' + d[0] + ' ' + dt[1];
        return r.substring(0, 16);
    }
    //----------------------------------------------------------------------
    $('#okSuccess').on('click',function () {
        location.reload();
    });
}]);

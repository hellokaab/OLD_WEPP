app.controller('addWorksheetCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.mySheetGroup = dataSheetGroup(myuser).responseJSON;
    $('#sheet_objective').Editor();
    $('#sheet_theory').Editor();
    $('#sheet_testing').Editor();

    $(document).ready(function () {
        $('#sheet_group').val($window.sheetGroupId);
    });
}]);
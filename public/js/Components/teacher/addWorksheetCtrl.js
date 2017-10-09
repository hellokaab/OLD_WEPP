app.controller('addWorksheetCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.mySheetGroup = dataSheetGroup(myuser).responseJSON;
    // $('#sheet_objective').Editor();
    // $('#sheet_theory').Editor();
    $('#sheet_testing').Editor();

    $scope.inputMode = 'no_input';
    $scope.outputMode = 'key_output';
    $scope.sheetName = '';
    $scope.output = '';
    $scope.input = '';

    //----------------------------------------------------------------------
    $scope.changeInputMode = function () {
        $scope.input = '';
        $('[name=sheet_file_input]').val('');
    };
    //----------------------------------------------------------------------
    $scope.changeOutputMode = function () {
        $scope.output = '';
        $('[name=sheet_file_output]').val('');
    };
    
    $scope.addWorksheet = function () {

    }

    // //----------------------------------------------------------------------
    // var entityMap = {
    //     "&": "&amp;",
    //     "<": "&lt;",
    //     ">": "&gt;",
    //     '"': '&quot;',
    //     "'": '&#39;',
    //     "/": '&#x2F;'
    // };
    //
    // function escapeHtml(string) {
    //     return String(string).replace(/[&<>"'\/]/g, function (s) {
    //         return entityMap[s];
    //     });
    // }
    //
    // //----------------------------------------------------------------------
    // function getExtension(filename) {
    //     var parts = filename.split('.');
    //     return parts[parts.length - 1];
    // }
    //
    // //----------------------------------------------------------------------
    // function checkTxtFile(filename) {
    //     var ext = getExtension(filename);
    //     if (ext.toLowerCase() === "txt") {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
    // //----------------------------------------------------------------------
    // function createContentFile(content, callback) {
    //     $.post("../public/js/Components/Contentfile.php", {
    //         Content: content
    //     }, function (data) {
    //         callback(data);
    //     });
    // }

    //----------------------------------------------------------------------
    $scope.goBack = function () {
        window.history.back();
    }

    $(document).ready(function () {
        $('#sheet_group').val($window.sheetGroupId);
    });
}]);
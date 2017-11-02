app.controller('myWorksheetCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.thisUser = $window.myuser;
    $scope.sheetGroup = $window.sheetGroup ;
    $scope.mySheet = findSheetByUserID($scope.thisUser.id);
    $scope.selectRow = '10';
    $scope.queryBy = 'sheet_group_name';
    $scope.sortS = 'sheet_group_name';
    $scope.sortC = 'group_admin';
    $scope.sheetGroupId = 0;


    $scope.keptID = function (data) {
        $scope.sheetGroupId = data.id;
        $('#listWorksheet').removeAttr('style');
    };
    //----------------------------------------------------------------------
    $scope.addMyWorksheetGroup = function () {
        $scope.MySheetName = '';
        $('#notice_name_add_mwsg').hide();
        $('#add_WorkSheet_Group_modal').modal({backdrop: 'static'});
        setTimeout(function () {
            $('[ng-model=MySheetName]').focus();
        }, 200);
    };
    //----------------------------------------------------------------------
    $scope.okAddMyWorksheetGroup = function () {
        if ($scope.MySheetName.length > 0) {
            var data = {
                user_id : $scope.thisUser.id,
                sheet_name: $scope.MySheetName
            };
            $('#addWorkSheetGroupPart').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });
            addMyWorksheetGroup(data);
        } else {
            $('#notice_name_add_mwsg').html('* กรุณาระบุชื่อกลุ่มใบงาน').show();
            $('[ng-model=MySheetName]').focus();
        }
    };
    //----------------------------------------------------------------------
    $scope.enterAdd = function() {
        $scope.okAddMyWorksheetGroup();
    };
    //----------------------------------------------------------------------
    $scope.sort = function(keyname){
        $scope.sortKey = keyname;   //set the sortKey to the param passed
        if($scope.sortKey === 'sheet_group_name'){
            $scope.reverseS = !$scope.reverseS; //if true make it false and vice versa
            if($scope.sortS === 'sheet_group_name'){
                $scope.sortS = '-sheet_group_name';
            } else {
                $scope.sortS = 'sheet_group_name';
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
    $scope.deleteWorksheet = function (data) {
        $scope.MySheetName = data.sheet_group_name;
        $scope.sheetGroupId = data.id;
        $('#delete_wsg_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okDeleteWorksheetGroup = function () {
        var dataWorksheetGroup = {
            id : $scope.sheetGroupId
        };
        $('#delete_WorksheetGroup_part').waitMe({
            effect: 'win8_linear',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        deleteWorksheetGroup(dataWorksheetGroup);
    };
    //----------------------------------------------------------------------
    $('#okSuccess').on('click',function () {
        window.location.href = url+'/myWorksheet';
    });
    //----------------------------------------------------------------------
    $scope.editWorksheet = function (data) {
        $scope.CurrentIndex = $scope.sheetGroup.indexOf(data);
        $scope.MySheetName = data.sheet_group_name;
        $scope.sheetGroupId = data.id;
        $('#notice_edit_worksheetGroup_ewsg').hide();
        $('#edit_worksheet_group_modal').modal({backdrop: 'static'});
        setTimeout(function () {
            $('[ng-model=MySheetName]').focus();
        }, 200);
    };
    //----------------------------------------------------------------------
    $scope.okEditSheetGroup = function () {
        if ($scope.MySheetName.length > 0) {
            var data = {
                id : $scope.sheetGroupId,
                sheet_name: $scope.MySheetName,
                user_id : $window.myuser.id
            };
            $('#edit_worksheet_group_part').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });
            editWorksheetGroup(data);
        } else {
            $('#notice_edit_worksheetGroup_ewsg').html('* กรุณาระบุชื่อกลุ่มใบงาน').show();
        }
    };
    //----------------------------------------------------------------------
    $scope.enterOkEdit = function() {
        $scope.okEditSheetGroup();
    };
    $scope.addWorksheet = function () {
        window.location.href = url+"/addWorksheet"+$scope.sheetGroupId;
    };
}]);
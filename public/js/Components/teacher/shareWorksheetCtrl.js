app.controller('shareWorksheetCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.thisUser = $window.myuser;
    $scope.sheetGroupSharedToMe = findSheetGroupSharedNotMe($window.myuser.id);
    $scope.sheetSharedToMe = findSheetSharedToMe($window.myuser.id);

    $scope.queryBy = 'sheet_group_name';
    $scope.selectRow = '10';
    $scope.sheetGroupId = 0;
    $scope.sortS = 'sheet_group_name';
    $scope.sortC = 'creater';
    $('#sheet_trial').Editor();
    //----------------------------------------------------------------------
    $scope.changeGroup = function (data) {
        $scope.sheetGroupId = data.id;
        $('#divSheetList').removeAttr('style');
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
            if($scope.sortC === 'creater'){
                $scope.sortC = '-creater';
            } else {
                $scope.sortC = 'creater';
            }
        }
    };
    //----------------------------------------------------------------------
    $scope.detailWorksheet = function (data) {
        $scope.sheetId = data.id;
        $('#sheetName').html(data.sheet_name);
        $('#fullScore').html(data.full_score);
        $('#notation').html(data.notation);
        $scope.quizzes = findQuizBySID(data.id);
        $('#detail_sheet_modal').modal({backdrop: 'static'});

        $('#objective_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        $('#theory_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        $('.Editor-editor').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        $('#input_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        $('#output_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });

        var fileDataSh = readFileSh(data);
        $('#objective').html(fileDataSh.objective);
        $('#theory').html(fileDataSh.theory);
        $('#sheet_trial').Editor('setText', decapeHtml(fileDataSh.trial));
        $('.Editor-editor').attr('contenteditable', false);
        $('[id^=menuBarDiv]').hide();
        $('[id^=statusbar]').hide();
        $('#sheetInput').html(fileDataSh.input);
        $('#sheetOutput').html(fileDataSh.output);

        $('#objective_part').waitMe('hide');
        $('#theory_part').waitMe('hide');
        $('.Editor-editor').waitMe('hide');
        $('#input_part').waitMe('hide');
        $('#output_part').waitMe('hide');
    };
    //----------------------------------------------------------------------
    function decapeHtml(str) {
        str = str.replace(/&amp;/g, '&');
        str = str.replace(/&lt;/g, '<');
        str = str.replace(/&gt;/g, '>');
        str = str.replace(/&quot;/g, '"');
        str = str.replace(/&#39;/g, "'");
        str = str.replace(/&#x2F;/g, '/');
        return str;
    }
    //----------------------------------------------------------------------
    $scope.copyWorksheet = function (data) {
        window.location.href = url+"/copyWorksheet"+data.id;
    };
    //----------------------------------------------------------------------
}]);

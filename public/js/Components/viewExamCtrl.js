app.controller('viewExamCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.examing = $window.examing;
    $scope.groupData = findGroupDataByID($scope.examing.group_id);
    if($scope.examing.examing_mode === 'n'){
        $scope.examExaming = findExamExamingInViewExam($scope.examing.id);
    } else {
        $scope.examExaming = findExamRandomInViewExam($scope.examing.id,myuser.id);
    }
    console.log($scope.examExaming);
}]);
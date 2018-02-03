app.controller('profileCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.prefix = myuser.prefix;
    $scope.fname = myuser.fname_th;
    $scope.lname = myuser.lname_th;
    $scope.personalID = myuser.personal_id;
    $scope.stuID = myuser.stu_id;
    $scope.faculty = myuser.faculty;
    $scope.department = myuser.department;
    $scope.email = myuser.email;
}]);


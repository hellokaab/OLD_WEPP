app.controller("loginCtrl", function($scope) {


    $scope.loginClick = function() {
        window.location.href = url + "index";
    }

    $scope.AdminLogin = function () {
        $('#admin_login_modal').modal({backdrop: 'static'});
    }
});
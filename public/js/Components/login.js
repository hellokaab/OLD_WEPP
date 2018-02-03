app.controller("loginCtrl", function($scope) {


    $scope.loginClick = function() {
        window.location.href = url + "makeData.php";
    };

    $scope.AdminLogin = function () {
        $('#admin_login_modal').modal({backdrop: 'static'});
        setTimeout(function () {
            $('[ng-model=adminUsername]').focus();
        }, 200);
        $scope.adminUsername = "";
        $scope.adminPassword = "";
    };

    $scope.okLogin = function () {
        $('#notice_admin_pass').hide();
        if($scope.adminUsername.length > 0 && $scope.adminPassword.length > 0){
            data = {
                username: $scope.adminUsername,
                password: $scope.adminPassword
            };
            $.ajax ({
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                headers: {
                    Accept: "application/json"
                },
                url: url + 'findAdmin',
                data: data,
                async: false,
                complete: function (xhr) {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            window.location.href = url+"teaList";
                            // alert("สำเร็จ");
                        } else if (xhr.status == 209){
                            $('#notice_admin_pass').html('* username หรือ password ไม่ถูกต้อง').show();
                            $('[ng-model=adminUsername]').focus();
                        } else {
                            alert("ผิดพลาด");
                        }
                    }
                }
            });
        } else  {
            $('#notice_admin_pass').html('* กรุณาระบุ username และ password').show();
            $('[ng-model=adminUsername]').focus();
        }

    }
});
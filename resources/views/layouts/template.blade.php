<!DOCTYPE html>
<html lang="en" ng-app = "myApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/side_nav.css" rel="stylesheet">
    <link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="waitMe/waitMe.css " rel="stylesheet" type="text/css">
    <link href="LineControl-Editor/editor.css " rel="stylesheet" type="text/css">
    <link href="dateTimePicker/DateTimePicker.min.css " rel="stylesheet" type="text/css">
    <link href="css/myCustom.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="highlight/styles/atom-one-dark.css">
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/side_nav.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="app/app.js"></script>
    <script src="waitMe/waitMe.js"></script>
    <script src="js/ajaxCtrl.js"></script>
    <script src="js/dirPagination.js"></script>
    <script src="LineControl-Editor/editor.js"></script>
    <script src="dateTimePicker/DateTimePicker.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="highlight/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    {{--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>--}}
    <script>
        app.controller("urlCtrl", function($scope) {
            $scope.myUrl = "/WEPP/public";
        });
        var url = "/WEPP/public";
        {{--var mysession = {--}}
            {{--personalId : "0425361073012",--}}
            {{--prename : "นาย",--}}
            {{--cn : "Pongpan",--}}
            {{--firstNameThai : "พงศ์พันธ์",--}}
            {{--sn : "Poonkhuntod",--}}
            {{--lastNameThai : "ปูนขุนทด",--}}
            {{--studentId : "",--}}
            {{--faculty : "คณะวิศวกรรมศาสตร์และสถาปัตยกรรมศาสตร์",--}}
            {{--program : "สาขาวิชาวิศวกรรมคอมพิวเตอร์",--}}
            {{--mail : "pongpan.kho@rmuti.ac.th",--}}
            {{--gidNumber : "2800"--}}
        {{--};--}}

        var mysession = {
            personalId : "0425361073013",
            prename : "นาย",
            cn : "Thanakorn",
            firstNameThai : "ธนกร",
            sn : "Chuensabai",
            lastNameThai : "ชื่นสบาย",
            studentId : "",
            faculty : "คณะวิศวกรรมศาสตร์และสถาปัตยกรรมศาสตร์",
            program : "สาขาวิชาวิศวกรรมคอมพิวเตอร์",
            mail : "pongpan.kho@rmuti.ac.th",
            gidNumber : "2800"
        }

        {{--var mysession = {--}}
            {{--personalId : "0425361073014",--}}
            {{--prename : "นาย",--}}
            {{--cn : "Sawatdee",--}}
            {{--firstNameThai : "สวัสดี",--}}
            {{--sn : "Meesuk",--}}
            {{--lastNameThai : "มีสุข",--}}
            {{--studentId : "",--}}
            {{--faculty : "คณะวิศวกรรมศาสตร์และสถาปัตยกรรมศาสตร์",--}}
            {{--program : "สาขาวิชาวิศวกรรมคอมพิวเตอร์",--}}
            {{--mail : "pongpan.kho@rmuti.ac.th",--}}
            {{--gidNumber : "2800"--}}
        {{--}--}}

        {{--var mysession = {--}}
            {{--personalId : "1103701635240",--}}
            {{--prename : "นาย",--}}
            {{--cn : "Pongpan",--}}
            {{--firstNameThai : "พงศ์พันธ์",--}}
            {{--sn : "Poonkhunthod",--}}
            {{--lastNameThai : "ปูนขุนทด",--}}
            {{--studentId : "561733022010-0",--}}
            {{--faculty : "คณะวิศวกรรมศาสตร์และสถาปัตยกรรมศาสตร์",--}}
            {{--program : "สาขาวิชาวิศวกรรมคอมพิวเตอร์",--}}
            {{--mail : "pongpan.po@rmuti.ac.th",--}}
            {{--gidNumber : "4500"--}}
        {{--};--}}

        {{--var mysession = {--}}
            {{--personalId : "1234567890123",--}}
            {{--prename : "นาย",--}}
            {{--cn : "Thanakorn",--}}
            {{--firstNameThai : "ธนกร",--}}
            {{--sn : "Chuensabai",--}}
            {{--lastNameThai : "ชื่นสบาย",--}}
            {{--studentId : "561733022033-2",--}}
            {{--faculty : "คณะวิศวกรรมศาสตร์และสถาปัตยกรรมศาสตร์",--}}
            {{--program : "สาขาวิชาวิศวกรรมคอมพิวเตอร์",--}}
            {{--mail : "pongpan.po@rmuti.ac.th",--}}
            {{--gidNumber : "4500"--}}
        {{--}--}}


    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>
    @yield('checkUser')
    <script>
        var myuser = findUserByPersonalID().responseJSON;
        var type="";
        if (myuser.user_type == 't'){
            type = "อาจารย์";
        }else if(myuser.user_type == 's') {
            type = "นักศึกษา";
        }else {
            type = "บุคลากร";
        }
        var name = "สวัสดีคุณ "+myuser.fname_th+" "+myuser.lname_th+' ('+type+')';
    </script>
</head>
<body id="page-top" class="index" ng-controller="urlCtrl">
@include('layouts.partials.navigation')

@include('layouts.partials.side_nav')
<!-- Success Modal -->
<div class="modal fade" id="success_modal" role="dialog">
    <div class="modal-dialog" style="width: 20%;padding-right: 12px">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h1 style="color: #28a745">สำเร็จ&nbsp;&nbsp;<i class="fa fa-check-circle" aria-hidden="true"></i></h1>
            </div>
            <div class="modal-footer">
                <button id="okSuccess" type="button" class="btn btn-outline-success" data-dismiss="modal">ตกลง</button>
            </div>
        </div>
    </div>
</div>

<!-- Unsuccess Modal -->
<div class="modal fade" id="unsuccess_modal" role="dialog">
    <div class="modal-dialog" style="width: 20%;padding-right: 12px">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h1 style="color: #dc3545">ผิดพลาด&nbsp;&nbsp;<i class="fa fa-times-circle" aria-hidden="true"></i></h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">ตกลง</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
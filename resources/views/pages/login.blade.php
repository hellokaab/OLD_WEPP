<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    {{--<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">--}}
    <link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="css/myCustom.css " rel="stylesheet" type="text/css">
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Components/login.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <style>

        .form-signin input[type="text"] {
            margin-bottom: 5px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .form-signin .form-control {
            position: relative;
            font-size: 16px;
            font-family: 'Open Sans', Arial, Helvetica, sans-serif;
            height: auto;
            padding: 10px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .vertical-offset-100 {
            padding-top: 100px;
        }

        .vertical-offset-10 {
            padding-top: 5%;
        }

        .img-responsive {
            display: block;
            max-width: 100%;
            height: auto;
            margin: auto;
        }

        .panel {
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.75);
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .navbar-toggle {
            border-color: #ddd
        }
    </style>

</head>
<body id="page-top" class="index">
<div class="container">
    <div class="row">
        <nav class="navbar navbar-custom">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand page-scroll" href="#page-top" id="projectName"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#services" id="test">ผู้จัดทำ</a>
                        </li>

                    <!-- Change Language Menu -->
                        {{--<li role="presentation" class="dropdown">--}}
                            {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button"--}}
                               {{--aria-haspopup="true" aria-expanded="false"><i class="fa fa-globe fa-lg"--}}
                                                                             {{--aria-hidden="true"></i> Thailand/ไทย <span--}}
                                        {{--class="caret"></span>--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu" style="padding-top: 15px;padding-bottom: 15px">--}}
                                {{--<li>--}}
                                    {{--<a href="#" style="width: 230px"><span>--}}
                                    {{--<img id="ukFlag" class="img-responsive" src="img/1496140767_United-Kingdom.png"--}}
                                         {{--style="width: 30px" align="left">--}}
                                        {{--</span>&nbsp;&nbsp;<span>United Kingdom/English</span></a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="#"><span>--}}
                                    {{--<img id="ukFlag" class="img-responsive" src="img/1496140759_Thailand.png"--}}
                                         {{--style="width: 30px" align="left">--}}
                                        {{--</span>&nbsp;&nbsp;<span>Thailand/ไทย</span></a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
        </nav>
    </div>
    <div class="row vertical-offset-10">
        <div class="col-md-7">
            <div class="center">
                <img class="img-responsive" src="img/logo.png">
            </div>
            <h2 style="text-align: center;margin-top: 25px">ระบบใบงานและการสอบเขียนโปรแกรมคอมพิวเตอร์ภาคปฏิบัติ</h2>
        </div>
        <div class="col-md-offset-1 col-md-4">
            <div class="row vertical-offset-100">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <fieldset>
                            <label class="panel-login col-md-12">
                                <div class="login_result"><h4 style="text-align: center">เข้าสู่ระบบด้วยบัญชี Single
                                        Sign-On ของทางมหาวิทยาลัย</h4></div>
                                <br>
                            </label>
                            <button href="#" class="btn btn-lg btn-success btn-block" style="margin-bottom: 5%"
                                    onclick=loginClick()>เข้าสู่ระบบ
                            </button>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<footer>
    <div class="container">
        <p style="text-align: center">สาขา<a href="http://www.cpe.rmuti.ac.th" rel="author">วิศวกรรมคอมพิวเตอร์</a>&nbsp;&nbsp;คณะ<a
                    href="http://www.ea.rmuti.ac.th/" rel="author">วิศวกรรมศาสตร์ และสถาปัตยกรรมศาสตร์</a>
        {{--<p style="text-align: center">--}}
        <p style="text-align: center"><a href="http://www.rmuti.ac.th" rel="author">มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</a>&nbsp;&nbsp;744
            ถนนสุรนารายณ์ ต.ในเมือง อ.เมือง จ.นครราชสีมา 30000</p>
    </div>
</footer>
</html>
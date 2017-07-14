<!-- Navigation -->
<script xmlns:php="http://www.w3.org/1999/html">
    $(document).ready(function () {
        var x = screen.width;
        if (parseInt(x) > 768) {
            document.getElementById("projectName").innerHTML = "ระบบใบงานและการสอบเขียนโปรแกรมคอมพิวเตอร์ภาคปฏิบัติ";
            $("#for-full-screen").css('display','block');
            $("#nav_home,#nav_exam_store,#nav_sheet_store,#nav_group,#nav_examing,#nav_sheeting,#nav_profile,#nav_logout").css('display','none');
        } else {
            document.getElementById("projectName").innerHTML = "WEPP";
            $("#for-full-screen").css('display','none');
            $("#nav_home,#nav_exam_store,#nav_sheet_store,#nav_group,#nav_examing,#nav_sheeting,#nav_profile,#nav_logout").css('display','block');
        }
        document.getElementById('nameUser').innerHTML = name;
    });

    $(window).resize(function () {
        var x = screen.width;
        if (parseInt(x) > 768) {
            document.getElementById("projectName").innerHTML = "ระบบใบงานและการสอบเขียนโปรแกรมคอมพิวเตอร์ภาคปฏิบัติ";
            $("#for-full-screen").css('display','block');
            $("#nav_home,#nav_exam_store,#nav_sheet_store,#nav_group,#nav_examing,#nav_sheeting,#nav_profile,#nav_logout").css('display','none');
        } else {
            document.getElementById("projectName").innerHTML = "WEPP";
            $("#for-full-screen").css('display','none');
            $("#nav_home,#nav_exam_store,#nav_sheet_store,#nav_group,#nav_examing,#nav_sheeting,#nav_profile,#nav_logout").css('display','block');
        }

    });
</script>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    {{--<div class="container">--}}
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
            <ul class="nav navbar-nav navbar-right" style="margin-right: auto">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <li id="nav_home" style="display: none">
                    <a  href="<%myUrl%>/index"><i class="fa2 fa-home fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;หน้าหลัก</a>
                </li>
                <li id="nav_profile" style="display: none">
                    <a href="#"><i class="fa2 fa-address-card fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;ข้อมูลส่วนตัว</a>
                </li>
                <li id="nav_exam_store" style="display: none">
                    <a href="<%myUrl%>/exam"><i class="fa2 fa-database fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;คลังข้อสอบ</a>
                </li>
                <li id="nav_sheet_store" style="display: none">
                    <a href="#"><i class="fa2 fa-archive fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;คลังใบงาน</a>
                </li>
                <li id="nav_group" style="display: none">
                    <a href="<%myUrl%>/group"><i class="fa2 fa-users fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;กลุ่มเรียน</a>
                </li>
                <li id="nav_examing" style="display: none">
                    <a href="#"><i class="fa2 fa-cog fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;จัดการการสอบ</a>
                </li>
                <li id="nav_sheeting" style="display: none">
                    <a href="#"><i class="fa2 fa-cogs fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;จัดการการสั่งใบงาน</a>
                </li>
                <li id="nav_logout" style="display: none">
                    <a href="#"><i class="fa2 fa-sign-out fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;ออกจากระบบ</a>
                </li>
                <li role="presentation" class="dropdown" id="for-full-screen" style="display: none">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                       aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"
                                                                     aria-hidden="true"></i>&nbsp;&nbsp;<label id="nameUser">testt
                        </label>&nbsp;&nbsp;<span
                                class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" style="padding-top: 15px;padding-bottom: 15px">
                        <li>
                            <a href="#" style="padding-top: 5px;padding-bottom: 5px;text-align: left">
                                <i class="fa fa-address-card fa-lg"
                                   aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;ข้อมูลส่วนตัว
                            </a>
                        </li>
                        <li>
                            <a href="#" style="padding-top: 5px;padding-bottom: 5px;text-align: left">
                            <i class="fa fa-sign-out fa-lg"
                               aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;ออกจากระบบ
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    {{--</div>--}}
    <!-- /.container-fluid -->
</nav>


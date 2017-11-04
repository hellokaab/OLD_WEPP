<script>
    $(document).ready(function () {
        var x = screen.width;
        if (parseInt(x) >= 768) {
            $("#sidebar-wrapper,#menu-toggle").css('display','block');
        } else {
            $("#sidebar-wrapper,#menu-toggle").css('display','none');
            $("#wrapper").removeAttr('class','toggled');
            $("#page-content-wrapper").removeAttr('style');
        }
    });

    $(window).resize(function () {
        var x = screen.width;
        if (parseInt(x) >= 768) {
            $("#sidebar-wrapper,#menu-toggle").css('display','block');
        } else {
            $("#sidebar-wrapper,#menu-toggle").css('display','none');
            $("#wrapper").removeAttr('class','toggled');
            $("#page-content-wrapper").removeAttr('style');
        }
    });

    app.controller("sideNavCtrl", function($scope) {
        $scope.thisUser = myuser;
    });
</script>

<div id="wrapper" class="toggled" ng-controller="sideNavCtrl">

    <!-- Sidebar -->
    <div id="sidebar-wrapper" style="display: none">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                   วันที่ 10 มิถุนายน 2560
                </a>
            </li>
            <li1>
                <a id="side_index" href="<%myUrl%>/index"><i class="fa2 fa-home fa-lg" aria-hidden="true" style="color: #db2828"></i>&nbsp;&nbsp;หน้าหลัก</a>
            </li1>
            <li2 ng-show="thisUser.user_type === 't'">
                <a data-target="#demo3" data-toggle="collapse" role="presentation" id="side_exam_store" href="" class="collapsed">
                    <i class="fa2 fa-database fa-lg" aria-hidden="true" style="color: #f2711c"></i>&nbsp;&nbsp;คลังข้อสอบ<i id="exam_chevron" class="fa2 fa-chevron-left" style="padding-left: 118px"></i>
                </a>
            </li2>
            <div class="collapse" id="demo3">
                <ul class="list-unstyled main-menu" id="_menu3" z="user-managed=">
                    <li2 role="presentation">
                        <a id="side_my_exam" href="<%myUrl%>/myExam">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;ข้อสอบของฉัน</a>
                        <a id="side_shared_exam" href="<%myUrl%>/exam">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;ข้อสอบที่แบ่งปันกับฉัน</a>
                    </li2>
                </ul>
            </div>
            <li3 ng-show="thisUser.user_type === 't'">
                <a data-target="#demo4" data-toggle="collapse" role="presentation" id="side_sheet_store" href="" class="collapsed">
                    <i class="fa2 fa-archive fa-lg" aria-hidden="true" style="color: #fbbd08"></i>&nbsp;&nbsp;คลังใบงาน <i id="sheet_chevron" class="fa2 fa-chevron-left" style="padding-left: 117px"></i>
                </a>
            </li3>
            <div class="collapse" id="demo4">
                <ul class="list-unstyled main-menu" id="_menu" z="user-managed=">
                    <li3 role="presentation">
                        <a id="side_my_Worksheet" href="<%myUrl%>/myWorksheet">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;ใบงานของฉัน</a>
                        <a id="side_shared_Worksheet" href="<%myUrl%>/shareWorksheet">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;ใบงานที่แบ่งปันกับฉัน</a>
                    </li3>
                </ul>
            </div>
            <li4 ng-show="thisUser.user_type === 't'">
                <a id="side_group" href="<%myUrl%>/group"><i class="fa2 fa-users fa-lg" aria-hidden="true" style="color: #21ba45"></i>&nbsp;&nbsp;กลุ่มเรียน</a>
            </li4>
            <li5 ng-show="thisUser.user_type === 't'">
                <a data-target="#demo" data-toggle="collapse" role="presentation" id="side_examming" href="" class="collapsed">
                    <i class="fa2 fa-cog fa-lg" aria-hidden="true" style="color: #2185d0"></i>&nbsp;&nbsp;จัดการการสอบ<i id="examming_chevron" class="fa2 fa-chevron-left" style="padding-left: 100px"></i>
                </a>
            </li5>
            <div class="collapse" id="demo">
                <ul class="list-unstyled main-menu" id="_menu" z="user-managed=">
                    <li5 role="presentation">
                        <a id="side_openExaming" href="<%myUrl%>/openExam">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;เปิดสอบ</a>
                        <a id="side_historyExaming" href="<%myUrl%>/examingHistory">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;ประวัติการเปิดสอบ</a>
                    </li5>
                </ul>
            </div>
            <li6 ng-show="thisUser.user_type === 't'">
                <a data-target="#demo2" data-toggle="collapse" role="presentation" id="side_sheeting" href="" class="collapsed">
                    <i class="fa2 fa-cogs fa-lg" aria-hidden="true" style="color: #6435c9"></i>&nbsp;&nbsp;จัดการการสั่งใบงาน<i id="sheeting_chevron" class="fa2 fa-chevron-left" style="padding-left: 70px"></i>
                </a>
            </li6>
            <div class="collapse" id="demo2">
                <ul class="list-unstyled main-menu" id="_menu2" z="user-managed=">
                    <li6 role="presentation">
                        <a href="#">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;สั่งใบงาน</a>
                        <a href="#">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;ประวัติการสั่งใบงาน</a>
                    </li6>
                </ul>
            </div>
            {{--<li ng-show="thisUser.user_type === 's'">--}}
                {{--<a id="side_std_group" href="<%myUrl%>/stdGroup"><i class="fa2 fa-users fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;กลุ่มเรียน</a>--}}
            {{--</li>--}}
            <li5 ng-show="thisUser.user_type === 's'">
                <a data-target="#demo_std_group" data-toggle="collapse" role="presentation" id="side_std_group" href="" class="collapsed">
                    <i class="fa2 fa-users fa-lg" aria-hidden="true" style="color: #2185d0"></i>&nbsp;&nbsp;กลุ่มเรียน<i id="std_group_chevron" class="fa2 fa-chevron-left" style="padding-left: 129px"></i>
                </a>
            </li5>
            <div class="collapse" id="demo_std_group">
                <ul class="list-unstyled main-menu" id="_menu_std_group" z="user-managed=">
                    <li5 role="presentation">
                        <a id="side_std_allGroup" href="<%myUrl%>/stdGroup">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;กลุ่มเรียนทั้งหมด</a>
                        <a id="side_std_myGroup" href="<%myUrl%>/stdMyGroup">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;กลุ่มเรียนของฉัน</a>
                    </li5>
                </ul>
            </div>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <div class="mini-submenu" href="#menu-toggle" id="menu-toggle">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" style="margin-left: 20px">
        <div class="container-fluid">
            <div class="row">
                    @yield('content')
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<script>

    $("#side_exam_store").on('click',function () {
        if($("#side_exam_store")[0].className == "collapsed"){
            $("#exam_chevron").removeAttr('class');
            $("#exam_chevron").attr('class','fa2 fa-chevron-down');
            $("#side_exam_store").attr('class','active');
        } else {
            $("#side_exam_store").removeAttr('class');
            $("#exam_chevron").removeAttr('class');
            $("#exam_chevron").attr('class','fa2 fa-chevron-left');

        }
    });

    $("#side_sheet_store").on('click',function () {
        if($("#side_sheet_store")[0].className == "collapsed"){
            $("#sheet_chevron").removeAttr('class');
            $("#sheet_chevron").attr('class','fa2 fa-chevron-down');
            $("#side_sheet_store").attr('class','active');
        } else {
            $("#side_sheet_store").removeAttr('class');
            $("#sheet_chevron").removeAttr('class');
            $("#sheet_chevron").attr('class','fa2 fa-chevron-left');

        }
    });

    $("#side_examming").on('click',function () {
        if($("#side_examming")[0].className == "collapsed"){
            $("#examming_chevron").removeAttr('class');
            $("#examming_chevron").attr('class','fa2 fa-chevron-down');
            $("#side_examming").attr('class','active');
        } else {
            $("#side_examming").removeAttr('class');
            $("#examming_chevron").removeAttr('class');
            $("#examming_chevron").attr('class','fa2 fa-chevron-left');

        }
    });

    $("#side_sheeting").on('click',function () {
        if($("#side_sheeting")[0].className == "collapsed"){
            $("#sheeting_chevron").removeAttr('class');
            $("#sheeting_chevron").attr('class','fa2 fa-chevron-down');
            $("#side_sheeting").attr('class','active');
        } else {
            $("#side_sheeting").removeAttr('class');
            $("#sheeting_chevron").removeAttr('class');
            $("#sheeting_chevron").attr('class','fa2 fa-chevron-left');

        }
    });

    $("#side_std_group").on('click',function () {
        if($("#side_std_group")[0].className == "collapsed"){
            $("#std_group_chevron").removeAttr('class');
            $("#std_group_chevron").attr('class','fa2 fa-chevron-down');
            $("#side_std_group").attr('class','active');
        } else {
            $("#side_std_group").removeAttr('class');
            $("#std_group_chevron").removeAttr('class');
            $("#std_group_chevron").attr('class','fa2 fa-chevron-left');

        }
    });
</script>


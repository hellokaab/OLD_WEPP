<script>
    $(document).ready(function () {
        var x = screen.width;
        if (parseInt(x) > 768) {
            $("#sidebar-wrapper,#menu-toggle").css('display','block');
        } else {
            $("#sidebar-wrapper,#menu-toggle").css('display','none');
            $("#wrapper").removeAttr('class','toggled');
        }
    });

    $(window).resize(function () {
        var x = screen.width;
        if (parseInt(x) > 768) {
            $("#sidebar-wrapper,#menu-toggle").css('display','block');
        } else {
            $("#sidebar-wrapper,#menu-toggle").css('display','none');
            $("#wrapper").removeAttr('class','toggled');
        }
    });


</script>

<div id="wrapper" class="toggled">

    <!-- Sidebar -->
    <div id="sidebar-wrapper" >
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                   วันที่ 10 มิถุนายน 2560
                </a>
            </li>
            <li>
                <a id="side_index" href="<%myUrl%>/index"><i class="fa2 fa-home fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;หน้าหลัก</a>
            </li>
            <li>
                <a id="side_exam_store" href="<%myUrl%>/exam"><i class="fa2 fa-database fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;คลังข้อสอบ</a>
            </li>
            <li>
                <a id="side_sheet_store" href="#"><i class="fa2 fa-archive fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;คลังใบงาน</a>
            </li>
            <li>
                <a id="side_group" href="<%myUrl%>/group"><i class="fa2 fa-users fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;กลุ่มเรียน</a>
            </li>
            <li>
                <a id="side_examming" href="#"><i class="fa2 fa-cog fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;จัดการการสอบ</a>
            </li>
            <li>
                <a id="side_sheeting" href="#"><i class="fa2 fa-cogs fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;จัดการการสั่งใบงาน</a>
            </li>
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


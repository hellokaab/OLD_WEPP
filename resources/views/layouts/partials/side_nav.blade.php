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
</script>

<div id="wrapper" class="toggled">

    <!-- Sidebar -->
    <div id="sidebar-wrapper" style="display: none">
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
                <a data-target="#demo" data-toggle="collapse" role="presentation" id="side_examming" href="" class="collapsed">
                    <i class="fa2 fa-cog fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;จัดการการสอบ<i id="examming_chevron" class="fa2 fa-chevron-left" style="padding-left: 100px"></i>
                </a>
            </li>
            <div class="collapse" id="demo">
                <ul class="list-unstyled main-menu" id="_menu" z="user-managed=">
                    <li id="company" role="presentation">
                        <a href="#">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;เปิดสอบ</a>
                        <a href="#">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;ประวัติการเปิดสอบ</a>
                    </li>
                </ul>
            </div>
            <li>
                <a data-target="#demo2" data-toggle="collapse" role="presentation" id="side_sheeting" href="" class="collapsed">
                    <i class="fa2 fa-cogs fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;จัดการการสั่งใบงาน<i id="sheeting_chevron" class="fa2 fa-chevron-left" style="padding-left: 70px"></i>
                </a>
            </li>
            <div class="collapse" id="demo2">
                <ul class="list-unstyled main-menu" id="_menu2" z="user-managed=">
                    <li id="company" role="presentation">
                        <a href="#">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;สั่งใบงาน</a>
                        <a href="#">&nbsp;&#09;&nbsp;&#09;&nbsp;&#09;&nbsp;ประวัติการสั่งใบงาน</a>
                    </li>
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
    $("#side_examming").on('click',function () {
        if($("#side_examming")[0].className == "collapsed"){
            $("#examming_chevron").removeAttr('class');
            $("#examming_chevron").attr('class','fa2 fa-chevron-down');
        } else {
            $("#examming_chevron").removeAttr('class');
            $("#examming_chevron").attr('class','fa2 fa-chevron-left');

        }
    })

    $("#side_sheeting").on('click',function () {
        if($("#side_sheeting")[0].className == "collapsed"){
            $("#sheeting_chevron").removeAttr('class');
            $("#sheeting_chevron").attr('class','fa2 fa-chevron-down');
        } else {
            $("#sheeting_chevron").removeAttr('class');
            $("#sheeting_chevron").attr('class','fa2 fa-chevron-left');

        }
    })
</script>


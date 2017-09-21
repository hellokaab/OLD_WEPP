@extends('layouts.template')
@section('content')
    <script src="js/Components/viewExamCtrl.js"></script>
    <script>
        var examingID = {{$examingID}};
        var examing = findExamingByID(examingID);
    </script>
    <div ng-controller="viewExamCtrl" style="display: none" id="view_exam_div">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="<%myUrl%>/index">หน้าหลัก</a></li>
                <li>กลุ่มเรียน</li>
                <li><a href="<%myUrl%>/stdMyGroup">กลุ่มเรียนของฉัน</a></li>
                <li><a href="<%myUrl%>/inGroup<%examing.group_id%>"><%groupData.group_name%> (<%groupData.creater%>)</a></li>
                <li class="active"><%examing.examing_name%></li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b><%examing.examing_name%></b>
                    <span id="time" style="float: right"><i class="fa fa-clock-o"></i> กำลังคำนวณเวลาในการสอบ...</span>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>ข้อที่</th>
                            <th>ชื่อข้อสอบ</th>
                            <th>สถานะ</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="e in examExaming">
                            <td><%$index + 1%></td>
                            <td><%e.exam_name%></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>

    <script>
        var second = 0;
        var timer;
        $(document).ready(function () {
            $('#view_exam_div').css('display', 'block');
            getNow();

//            $(".nav-tabs a").click(function () {
//                $(this).tab('show');
//            });
//            $('.nav-tabs a').on('shown.bs.tab', function (event) {
//                var x = $(event.target).text();         // active tab
//                var y = $(event.relatedTarget).text();  // previous tab
//                $(".act span").text(x);
//                $(".prev span").text(y);
//            });
        });

        function getNow() {
                a = new Date();
                b = dtDBToDtJs(examing.end_date_time);
                b = new Date(b);
                total = b.getTime() - a.getTime();
                second = parseInt(total / 1000);
                clearInterval(timer);
                countdown();
        }

        function dtDBToDtJs(date) {
            dt = date.split(' ');
            d = dt[0].split('-');
            jsDt = d[1] + '/' + d[2] + '/' + d[0] + ' ' + dt[1];
            return jsDt;
        }

        function countdown() {
            timer = setInterval(function () {
                if (second <= 0)
                    location.href = 'examing.php';
                hour = parseInt(second / 3600);
                min = parseInt((second % 3600) / 60);
                sec = second % 60;
                $('#time').html('<i class="fa fa-clock-o"></i> เหลือเวลาสอบ ' + hour + ' ชั่วโมง ' + min + ' นาที ' + sec + ' วินาที');
                second--;

                if (second % 600 === 0)
                    getNow();
                if (second % 600 === 600 || second % 600 === 599 || second % 600 === 598 || second % 600 === 597 || second % 600 === 596)
                    $('#time').html('<i class="fa fa-clock-o"></i> สิ้นสุดการสอบเวลา ' + examing.end_date_time);

            }, 1000);
        }
    </script>
@endsection
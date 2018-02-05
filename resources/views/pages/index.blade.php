@extends('layouts.template')
@section('checkUser')

@endsection
@section('content')
    <script src="js/Components/indexCtrl.js"></script>
    <div ng-controller="indexCtrl" style="display: none" id="index_div">
    <div class="row" style="height: 100%">
        <div class="col-lg-12" style="height: 100%">
            <div class="col-lg-8" style="height: 100%">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b style="color: #555">ปฏิทินกิจกรรมของฉัน</b>
                    </div>
                    <div class="panel-body">
                        <div id='calendar'></div>
                    </div>
                </div>
                {{--<h1>Simple Sidebar</h1>--}}
                {{--<p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and--}}
                    {{--will appear non-collapsed on larger screens. When toggled using the button below, the menu will--}}
                    {{--appear/disappear. On small screens, the page content will be pushed off canvas.</p>--}}
                {{--<p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>--}}
            </div>
            <div class="col-md-4" style="height: 100%">
                <div class="panel panel-default" style="height: 100%">
                    <div class="panel-heading" style="height: 100%">
                        <b style="color: #555">ผู้ที่ใช้งานระบบในปัจจุบัน</b>
                    </div>
                    <div class="panel-body" style="height: 100px">
                        <ul>
                            <li ng-repeat="u in userOnline"><a><%u.user_type == 't' ? "อ." : u.prefix%><%u.fname_th%> <%u.lname_th%></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@extends('layouts.template')
@section('content')
    <script src="js/Components/editExamingCtrl.js"></script>
    <script>
        var examingID = {{$examingID}};
    </script>
    <div ng-controller="editExamingCtrl">
        <div class="col-lg-12">
            <div class="panel panel-default" id="edit_examing_part">
                <div class="panel-heading">
                    <b style="color: #555">แก้ไขการเปิดสอบ</b>
                </div>
                <div class="panel-body"></div>
            </div>
        </div>
    </div>
@endsection
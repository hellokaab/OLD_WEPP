@extends('layouts.template')

@section('content')
    <script src="js/Components/profileCtrl.js"></script>
    <div ng-controller="profileCtrl">
        <div class="container"style="width: 700px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">ข้อมูลส่วนตัว</div>
                    <div class="panel-body">
                        <div class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-3 control-label">คำนำหน้า</label>
                                <div class="col-md-8" style="right: 20px">
                                    <input type="text" class="form-control"ng-model="prefix" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">ชื่อ</label>
                                <div class="col-md-8" style="right: 20px">
                                    <input type="text" class="form-control"ng-model="fname"disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">นามสกุล</label>
                                <div class="col-md-8" style="right: 20px">
                                    <input type="text" class="form-control"ng-model="lname"disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">รหัสประชาชน</label>
                                <div class="col-md-8" style="right: 20px">
                                    <input type="text" class="form-control"ng-model="personalID"disabled>
                                </div>
                            </div>

                            <div class="form-group" ng-hide="stuID ===''">
                                <label class="col-md-3 control-label" >รหัสนักศึกษา</label>
                                <div class="col-md-8" style="right: 20px">
                                    <input type="text" class="form-control"ng-model="stuID"disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">คณะ</label>
                                <div class="col-md-8" style="right: 20px">
                                    <input type="text" class="form-control"ng-model="faculty"disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">สาขา</label>
                                <div class="col-md-8" style="right: 20px">
                                    <input type="text" class="form-control"ng-model="department"disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">อีเมล</label>
                                <div class="col-md-8" style="right: 20px">
                                    <input type="text" class="form-control"ng-model="email"disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
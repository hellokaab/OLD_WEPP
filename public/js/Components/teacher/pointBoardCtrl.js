app.controller('pointBoardCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.examingID = $window.examingID;
    $scope.examing = findExamingByID($scope.examingID);
    $scope.group = findGroupDataByID($scope.examing.group_id);
    $scope.examExaming = findExamInScoreboard($scope.examingID);
    $scope.pointBoard = dataInScoreboard($scope.examing);

    $scope.scoreExams = new Array();
    $scope.examExaming.forEach(function(exam) {
        $scope.scoreExams.push(exam.full_score);
    });
    $scope.changeScore = false;
    $scope.edited = false;
    $scope.tab = 'a';
    //----------------------------------------------------------------------
    $scope.viewResExamHistory = function (data) {
        console.log(data);

        $scope.resexam = data;
        $scope.pathExam = findPathExamByResExamID(data.id);
        console.log($scope.pathExam);

        $('#resExam_modal').modal({backdrop: 'static'});
        var user = findUserByID(data.user_id);
        var exam = findExamByID(data.exam_id);
        $scope.examID = exam.id;
        $scope.resexamID = data.id;
        $scope.stdScore = data.score;
        $scope.currentScore = data.score;
        $scope.examFullScore = exam.full_score;
        $("#stdName").html(user.prefix+user.fname_th+" "+user.lname_th);
        $("#stdCode").html(user.stu_id);
        $("#examName").html(exam.exam_name);
        $("#full_score_exam").html("/ "+exam.full_score);

        $scope.pathExam.forEach(function(pathRes) {
            pathRes.code = getCode(pathRes.path);
            pathRes.teaOutput = (readFile(exam).responseJSON).output;
        });

        console.log($scope.pathExam);
    };
    //----------------------------------------------------------------------
    $scope.viewExam = function () {
        window.open(url+'/detailExam' + $scope.examID, '', 'scrollbars=1, width=1000, height=600');
    };
    //----------------------------------------------------------------------
    $scope.editScore = function () {
        $('#notice_std_score').hide();
        $('#success_std_score').hide();
        $scope.changeScore = true;
        $('#std_score').removeAttr('disabled');
        $('#std_score').focus();
    };
    //----------------------------------------------------------------------
    $scope.okEdit = function () {
        if($.isNumeric($scope.stdScore) && $scope.stdScore > 0){
            if($scope.stdScore <= $scope.examFullScore){
                $('#notice_std_score').hide();
                editScore($scope.resexamID,$scope.stdScore);
                $('#success_std_score').html('* บันทึกคะแนนสำเร็จ').show();
                // $scope.currentScore = $scope.stdScore;
                $('#std_score').attr('disabled','disabled');
                $scope.changeScore = false;
                $scope.edited = true;
            } else {
                $('#notice_std_score').html('* กรุณาระบุคะแนนไม่เกินคะแนนเต็มของข้อสอบ').show();
                $('#std_score').focus();
            }
        } else {
            $('#notice_std_score').html('* กรุณาระบุคะแนนให้ถูกต้อง').show();
            $('#std_score').focus();
        }
    };
    //----------------------------------------------------------------------
    $scope.cancleEdit = function () {
        $('#notice_std_score').hide();
        $('#success_std_score').hide();
        $scope.changeScore = false;
        $('#std_score').attr('disabled','disabled');
        $scope.stdScore = $scope.currentScore;
    };
    //----------------------------------------------------------------------
    $('#resExam_modal').on('hidden.bs.modal', function(){
        if($scope.edited){
            location.reload();
        }
    });
    //----------------------------------------------------------------------
    $scope.changeTab = function (status) {
        $scope.tab = status;
    };
    //----------------------------------------------------------------------
    $scope.viewCode = function (data) {
        if ($('#detail_' + data.id).attr('style') === 'display: none;') {

            var code = "";
            (data.code).forEach(function(codes) {
                code+=codes;
            });
            $('#code_' + data.id).html(code);
            $('#resrun_' + data.id).html(data.resrun);
            $('#tea_output_' + data.id).html(data.teaOutput);

            $('mycode').each(function(i, block) {
                hljs.highlightBlock(block);
            });

            $('#detail_' + data.id).show();
        }
        else {
            $('#detail_' + data.id).hide();
        }
    };
}]);


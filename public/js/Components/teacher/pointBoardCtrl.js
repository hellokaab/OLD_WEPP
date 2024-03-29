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
        $scope.resexam = data;
        $scope.pathExam = findPathExamByResExamID(data.id);

        $('#resExam_modal').modal({backdrop: 'static'});
        $('#resExam_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });

        setTimeout(function () {

            var user = findUserByID(data.user_id);
            var exam = findExamByID(data.exam_id);
            $scope.examID = exam.id;
            $scope.resexamID = data.id;
            // $scope.stdScore = data.score;
            $("#std_score").val(data.score);
            $scope.currentScore = data.score;
            $scope.examFullScore = exam.full_score;
            $("#stdName").html(user.prefix+user.fname_th+" "+user.lname_th);
            $("#stdCode").html(user.stu_id);
            $("#examName").html(exam.exam_name);
            $("#full_score_exam").html("/ "+exam.full_score);

            $scope.pathExam.forEach(function(pathRes) {
                pathRes.code = getCode(pathRes.path);
                pathRes.teaOutput = (readFile(exam).responseJSON).output;
                pathRes.readResrun = readFileResRun(pathRes.resrun);
            });

            $('#resExam_part').waitMe('hide');
        }, 420);
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
                $scope.currentScore = $scope.stdScore;
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
            $('#code_' + data.id).html(escapeHtml(code));
            $('#tea_output_' + data.id).html('<span class="hljs-right">'+data.teaOutput+'</span>');
            $('#resrun_' + data.id).html(changColor(data.readResrun,data.teaOutput));
            console.log(changColor(data.readResrun,data.teaOutput));

            $('mycode').each(function(i, block) {
                hljs.highlightBlock(block);
            });

            $('#detail_' + data.id).show();
        }
        else {
            $('#detail_' + data.id).hide();
        }
    };
    //----------------------------------------------------------------------
    $scope.checkTab = function (data) {
        if($scope.tab === data.status){
            return true;
        } else {
            if($scope.tab === 'i' && (data.status === '5' || data.status === '6' || data.status === '7' || data.status === '8' || data.status === '9')){
                return true;
            }
        }
        return false;
    };
    //----------------------------------------------------------------------
    var entityMap = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': '&quot;',
        "'": '&#39;',
        "/": '&#x2F;'
    };

    function escapeHtml(string) {
        return String(string).replace(/[&<>"'\/]/g, function (s) {
            return entityMap[s];
        });
    }
    //----------------------------------------------------------------------
    function changColor(resrun,teaOuput) {
        str='';
        insertMyCut = false;
        strAfterChange='';
        try{
            for(i=0;i<resrun.length || i<teaOuput.length;i++){
                if(teaOuput[i] === resrun[i]){
                    str+=resrun[i];
                    if(insertMyCut){
                        str+="myCut"+resrun[i];
                        insertMyCut = false;
                    }
                }else {
                    if(insertMyCut){
                        if(i > resrun.length-1){
                            str+="_";
                        }else {
                            str+=resrun[i];
                        }
                    } else {
                        if(i > resrun.length-1){
                            str+="myCut"+"_";
                        }else {
                            str+="myCut"+resrun[i];
                        }
                        insertMyCut = true;
                    }
                }
            }
            if(insertMyCut){
                str+="myCut";
            }
        }catch(err) {}

        arrayStr = str.split('myCut');
        for(i=0;i<arrayStr.length;i++){
            if(i%2===0){
                strAfterChange += '<span class="hljs-right">'+arrayStr[i]+'</span>';
            } else {
                strAfterChange += '<span class="hljs-wrong">'+arrayStr[i]+'</span>';
            }
        }
        return strAfterChange;
    }
}]);


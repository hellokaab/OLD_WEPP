app.controller('addWorksheetCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.mySheetGroup = findMySheetGroup(myuser).responseJSON;
    $scope.teacher = findTeacher();
    $scope.thisUser = $window.myuser;
    // $('#sheet_objective').Editor();
    // $('#sheet_theory').Editor();
    $('#sheet_trial').Editor();

    var quiz = new Array();
    $scope.inputMode = 'no_input';
    $scope.outputMode = 'key_output';
    $scope.sheetName = '';
    $scope.output = '';
    $scope.input = '';
    $scope.main = '';
    $scope.classTestMode = '0';
    $scope.casesensitive = '1';
    $scope.completeNoDuplicate = true;
    $scope.sheetScore = '';
    $scope.objective = '';
    $scope.theory = '';
    $scope.sheetNotation = '';
    $scope.selectTeacher = [];

    $(document).ready(function () {
        $('#sheet_group').val($window.sheetGroupId);
    });

    //----------------------------------------------------------------------
    $scope.changeInputMode = function () {
        $scope.input = '';
        $('[name=sheet_file_input]').val('');
    };
    //----------------------------------------------------------------------
    $scope.changeOutputMode = function () {
        $scope.output = '';
        $('[name=sheet_file_output]').val('');
    };
    //----------------------------------------------------------------------
    $scope.changeClassTestMode = function () {
        $scope.main = '';
    };
    //----------------------------------------------------------------------
    $scope.addWorksheet = function () {
        $('#notice_sheet_name').hide();
        $('#notice_sheet_trial').hide();
        $('#notice_sheet_txt_input').hide();
        $('#notice_sheet_file_input').hide();
        $('#notice_sheet_txt_output').hide();
        $('#notice_sheet_file_output').hide();
        $('#notice_sheet_main_input').hide();
        $('#notice_sheet_score').hide();
        $('#notice_sheet_notation').hide();
        $('#notice_sheet_theory').hide();
        $('#notice_sheet_objective').hide();
        $('[id^=notice_sheet_quiz_]').each(function () {
            $(this).hide();
        });
        $('[id^=notice_quiz_score_]').each(function () {
            $(this).hide();
        });

        $scope.completeSheetName = $scope.sheetName.length > 0;
        if ($scope.completeSheetName) {
            $scope.completeNoDuplicate = findSheetByName($scope.sheetName, $('#sheet_group').val(), myuser.id);
        }
        $scope.completeTrialContent = $('#sheet_trial').Editor("getText").length > 0;
        $scope.completeInputMode = $scope.inputMode === 'no_input' ? true :
            $scope.inputMode === 'key_input' ? ($scope.input === '' ? false : true) :
                $scope.inputMode === 'file_input' ? ($('[name=sheet_file_input]').val() === '' ? false : checkTxtFile($('[name=sheet_file_input]').val())) : false;
        $scope.completeOutputMode = $scope.outputMode === 'key_output' ? ($scope.output === '' ? false : true) :
            $scope.outputMode === 'file_output' ? ($('[name=sheet_file_output]').val() === '' ? false : checkTxtFile($('[name=sheet_file_output]').val())) : false;
        $scope.completeClassTest = $scope.classTestMode === '0' ? true :
            $scope.classTestMode === '1' ? ($scope.main === '' ? false : true) : false;
        $scope.completeScore = $scope.sheetScore.length > 0;
        $scope.completeQuiz = checkQuiz();


        if ($scope.completeSheetName
            && $scope.completeNoDuplicate
            && $scope.completeTrialContent
            && $scope.completeInputMode
            && $scope.completeOutputMode
            && $scope.completeClassTest
            && $scope.completeScoreNumeric
            && $scope.completeQuiz
            && $scope.completeScore){

            $('#add_sheet_part').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });

            createContentFile(escapeHtml($('#sheet_trial').Editor("getText")), function (result) {
                var resultJson = JSON.parse(result);
                $scope.trialPath = resultJson.trial_path;
                var trial_path_split = $scope.trialPath.split('/');
                var path = "";
                for(var i=0;i<trial_path_split.length-1;i++){
                    path += trial_path_split[i]+"*";
                }

                if ($scope.inputMode === 'no_input') {
                    $scope.inputPath = "";
                } else if ($scope.inputMode === 'key_input') {
                    $scope.inputPath = resultJson.input_path;
                } else {
                    $window.pathSheet = path;
                    $('#inputFileForm').submit();
                    $scope.inputPath = $window.input_part;
                }

                if ($scope.outputMode === 'key_output') {
                    $scope.outputPath = resultJson.output_path;
                } else {
                    $window.pathSheet = path;
                    $('#outputFileForm').submit();
                    $scope.outputPath = $window.output_part;
                }

                if($scope.classTestMode == 1){
                    $scope.mainPath = resultJson.main_path;
                } else {
                    $scope.mainPath = "";
                }

                $scope.objectivePath = resultJson.objective_path;
                $scope.theoryPath = resultJson.theory_path;

                getQuiz();
                data = {
                    user_id: $window.myuser.id,
                    sheet_group_id: $('#sheet_group').val(),
                    sheet_name: $scope.sheetName,
                    sheet_trial: $scope.trialPath,
                    sheet_input_file: $scope.inputPath,
                    sheet_output_file: $scope.outputPath,
                    objective: $scope.objectivePath,
                    theory: $scope.theoryPath,
                    notation: $scope.sheetNotation,
                    full_score: $scope.sheetScore,
                    main_code: $scope.mainPath,
                    case_sensitive: $scope.casesensitive,
                    quiz : quiz
                };
                if($scope.selectTeacher.length>0){
                    data.shared = $scope.selectTeacher;
                } else {
                    var share = new Array();
                    data.shared = share;
                }
                createWorksheet(data);
            });

        } else {
            if (!$scope.completeScoreNumeric) {
                $('#notice_sheet_score').html('* กรุณาระบุเฉพาะจำนวนเต็มบวกเท่านั้น').show();
                $('[ng-model=sheetScore]').focus();
            }
            if (!$scope.completeScore) {
                $('#notice_sheet_score').html('* กรุณาระบุคะแนนการทดลอง').show();
                $('[ng-model=sheetScore]').focus();
            }

            if (!$scope.completeClassTest) {
                $('#notice_sheet_main_input').html('* กรุณาระบุ method main ของใบงาน').show();
                $('[ng-model=main]').focus();
            }

            if (!$scope.completeOutputMode) {
                if ($scope.outputMode === 'key_output') {
                    $('#notice_sheet_txt_output').html('* กรุณาระบุ Output ของใบงาน').show();
                    $('[ng-model=output]').focus();
                } else {
                    if ($('[name=sheet_file_output]').val() === '') {
                        $('#notice_sheet_file_output').html('* กรุณาระบุไฟล์ Output ของใบงาน').show();
                    } else {
                        $('#notice_sheet_file_output').html('* กรุณาระบุไฟล์ .txt เท่านั้น').show();
                    }
                    $('[name=sheet_file_output]').focus();
                }
            }
            if (!$scope.completeInputMode) {
                if ($scope.inputMode === 'key_input') {
                    $('#notice_sheet_txt_input').html('* กรุณาระบุ Input ของใบงาน').show();
                    $('[ng-model=input]').focus();
                } else {
                    if ($('[name=sheet_file_input]').val() === '') {
                        $('#notice_sheet_file_input').html('* กรุณาระบุไฟล์ Input ของใบงาน').show();
                    } else {
                        $('#notice_sheet_file_input').html('* กรุณาระบุไฟล์ .txt เท่านั้น').show();
                    }
                    $('[name=sheet_file_input]').focus();
                }
            }

            if (!$scope.completeTrialContent) {
                $('#notice_sheet_trial').html('* กรุณาระบุรายละเอียดของการทดลอง').show();
                $('.Editor-editor').focus();
            }

            if (!$scope.completeSheetName) {
                $scope.completeNoDuplicate = true;
                $('#notice_sheet_name').html('* กรุณาระบุชื่อใบงาน').show();
                $('[ng-model=sheetName]').focus();
            }

            if (!$scope.completeNoDuplicate) {
                $('#notice_sheet_name').html('* ใบงานนี้มีอยู่แล้ว').show();
                $('[ng-model=sheetName]').focus();
            }
        }
    };
    //----------------------------------------------------------------------
    $scope.goBack = function () {
        window.history.back();
    };
    //----------------------------------------------------------------------
    $('#okSuccess').on('click',function () {
        window.location.href = url+'/myWorksheet';
    });
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
    function checkTxtFile(filename) {
        var ext = getExtension(filename);
        if (ext.toLowerCase() === "txt") {
            return true;
        } else {
            return false;
        }
    }
    function getExtension(filename) {
        var parts = filename.split('.');
        return parts[parts.length - 1];
    }
    //----------------------------------------------------------------------
    function createContentFile(trial, callback) {
        $.post("js/Components/CreateTextFileSH.php", {
            objective : $scope.objective,
            theory : $scope.theory,
            trial: trial,
            input : $scope.input,
            output : $scope.output,
            main: $scope.main,
            userID : myuser.id,
            userName : myuser.fname_en+"_"+myuser.lname_en,
            sheet_group_id: $('#sheet_group').val()
        }, function (data) {
            callback(data);
        });
    }
    //----------------------------------------------------------------------
    $scope.checkFullScore = function () {
        $('#notice_sheet_score').hide();

        $scope.completeScoreNumeric = false;
        if ($.isNumeric($scope.sheetScore) && $scope.sheetScore.indexOf('.') < 0 && $scope.sheetScore > 0) {
            $scope.completeScoreNumeric = true;
        } else {
            $('#notice_sheet_score').html('* กรุณาระบุเฉพาะจำนวนเต็มบวกเท่านั้น').show();
        }
    };
    //----------------------------------------------------------------------
    function getQuiz() {
        quiz = new Array();
        $('[id^=quiz_part_]').each(function () {
            if(!(($(this).children().children().children()[0].value).trim().length === 0
                && ($(this).children().children().children()[2].value).trim().length === 0
                && ($(this).children().children().children()[3].value).trim().length === 0))
            {
                data = {
                    quiz : ($(this).children().children().children()[0].value).trim(),
                    answer : ($(this).children().children().children()[2].value).trim(),
                    score : ($(this).children().children().children()[3].value).trim()
                }
                quiz.push(data);
            }
        });
    }
    //----------------------------------------------------------------------
    function checkQuiz() {
        var checked = true;
        $('[id^=quiz_part_]').each(function () {
            thisID = ($(this)[0].id).split('_')[2];
            if(!(($(this).children().children().children()[0].value).trim().length === 0
                && ($(this).children().children().children()[2].value).trim().length === 0
                && ($(this).children().children().children()[3].value).trim().length === 0))
            {
                if (($(this).children().children().children()[0].value).trim().length === 0){
                    $('#notice_sheet_quiz_'+thisID).html('* กรุณาระบุคำถาม').show();
                    checked = false
                }
                if(($(this).children().children().children()[3].value).trim().length === 0){
                    $('#notice_quiz_score_'+thisID).html('* กรุณาระบุคะแนนคำถาม').show();
                    checked = false
                }else if(!$.isNumeric($(this).children().children().children()[3].value)){
                    $('#notice_quiz_score_'+thisID).html('* กรุณาระบุคะแนนให้ถูกต้อง').show();
                    checked = false
                }
            }
        });
        return checked;
    }
    //----------------------------------------------------------------------
    $scope.addUserShare = function () {
        $('#add_user_to_share_modal').modal({backdrop: 'static'});
    };
    //----------------------------------------------------------------------
    $scope.okAddTeacher = function () {
        $('#add_user_share_part').waitMe({
            effect: 'facebook',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        $scope.selectTeacher = [];
        $('[id^=tea_]').each(function () {
            if ($(this).prop('checked')) {
                var indexOfStevie = $scope.teacher.findIndex(i => i.id == $(this).attr('id').substr(4));
                $scope.selectTeacher.push($scope.teacher[indexOfStevie]);
            }
        });
        $('#add_user_share_part').waitMe('hide');
        $('#add_user_to_share_modal').modal('hide');
    };
    //----------------------------------------------------------------------
    $scope.ticExam = function (id) {
        if($('#tea_'+id)[0].checked){
            $('#tea_'+id)[0].checked = false;
        } else {
            $('#tea_'+id)[0].checked = true;
        }
    };
    //----------------------------------------------------------------------
    $('#select_all').on('change',function () {
        if($('#select_all')[0].checked){
            $('[id^=tea_]').each(function () {
                $(this)[0].checked = true;
            });
        } else {
            $('[id^=tea_]').each(function () {
                $(this)[0].checked = false;
            });
        }
    })
}]);
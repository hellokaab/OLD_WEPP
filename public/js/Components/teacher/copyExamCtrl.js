app.controller('copyExamCtrl', ['$scope', '$window', function ($scope, $window) {
    // $scope.groups = $window.group_list;
    var newKeywords = new Array();
    $scope.examData = findExamByID(window.examId).responseJSON;
    $scope.groupId = "0";
    $scope.keywords = window.keywords;
    $scope.thisUser = $window.myuser;
    $scope.teacher = findTeacher();
    $scope.sharedUser = findSharedUserNotMe($scope.examData.id,$scope.thisUser.id);
    $scope.selectTeacher = [];
    // console.log($scope.sharedUser);

    $scope.mySection = findMySection(myuser).responseJSON;
    $('#exam_content').Editor();
    // Exam name
    $scope.examName = $scope.examData.exam_name;


    $(document).ready(function () {
        // Exam group
        $('#ddl_group').val($scope.groupId);
    });
    var fileData = readFile($scope.examData).responseJSON;

    // Exam content
    $('#exam_content').Editor('setText', decapeHtml(fileData.content));

    // Exam input
    $scope.inputMode = 'no_input';
    if ($scope.examData.exam_inputfile) {
        $scope.inputMode = 'key_input';
        $scope.input = fileData.input;
    }

    // Exam output
    $scope.outputMode = 'key_output';
    $scope.output = fileData.output;

    // Exam main code
    $scope.classTestMode = '0';
    if ($scope.examData.main_code) {
        $scope.classTestMode = '1';
        $scope.main = fileData.main;
    }

    // Exam casesensitive
    $scope.casesensitive = $scope.examData.case_sensitive;

    // // Keywords
    // $window.numOldKeyword = 0;
    // $.each($scope.examData[0].keyword, function () {
    //     $window.numOldKeyword++;
    // });
    //
    // Exam limit
    $scope.memLimit = $scope.examData.memory_size;
    $scope.timeLimit = $scope.examData.time_limit;

    // Exam score
    $scope.fullScore = $scope.examData.full_score;
    $scope.imperfectScore = $scope.examData.accep_imperfect;

    // Exam cut score
    $scope.cutWrongAnswer = $scope.examData.cut_wrongans;
    $scope.cutComplieError = $scope.examData.cut_comerror;
    $scope.cutOverMem = $scope.examData.cut_overmemory;
    $scope.cutOverTime = $scope.examData.cut_overtime;

    $scope.completeMemLimit = true;
    $scope.completeTimeLimit = true;
    $scope.completeFullScore = true;
    $scope.completeImperfectScore = true;
    $scope.completeCutWrongAnswer = true;
    $scope.completeCutComplieError = true;
    $scope.completeCutOverMem = true;
    $scope.completeCutOverTime = true;


    // //----------------------------------------------------------------------
    // $scope.changeGroup = function (data) {
    //     $scope.groupId = data.exam_group_id;
    // };
    //
    //----------------------------------------------------------------------
    $scope.changeInputMode = function () {
        $scope.input = '';
        $('[name=exam_file_input]').val('');
    };
    //----------------------------------------------------------------------
    $scope.changeOutputMode = function () {
        $scope.output = '';
        $('[name=exam_file_output]').val('');
    };
    //----------------------------------------------------------------------
    $scope.changeClassTestMode = function () {
        $scope.main = '';
    };

    //----------------------------------------------------------------------
    $scope.checkMemLimit = function () {
        $('#notice_exam_limit').hide();

        $scope.completeMemLimit = false;
        if ($.isNumeric($scope.memLimit) && $scope.memLimit.indexOf('.') < 0 && $scope.memLimit > 0) {
            $scope.completeMemLimit = true;
        } else {
            $('#notice_exam_limit').html('* กรุณาระบุเฉพาะจำนวนเต็มบวกเท่านั้น').show();
        }
    };
    //----------------------------------------------------------------------
    $scope.checkTimeLimit = function () {
        $('#notice_exam_limit').hide();

        $scope.completeTimeLimit = false;
        if ($.isNumeric($scope.timeLimit) && $scope.timeLimit > 0) {
            $scope.completeTimeLimit = true;
        } else {
            $('#notice_exam_limit').html('* กรุณาระบุเวลาในการประมวลผลให้ถูกต้อง').show();
        }
    };

    //----------------------------------------------------------------------
    $scope.checkFullScore = function () {
        $('#notice_exam_score').hide();

        $scope.completeFullScore = false;
        if ($.isNumeric($scope.fullScore) && $scope.fullScore.indexOf('.') < 0 && $scope.fullScore > 0) {
            $scope.completeFullScore = true;
        } else {
            $('#notice_exam_score').html('* กรุณาระบุเฉพาะจำนวนเต็มบวกเท่านั้น').show();
        }
    };
    //----------------------------------------------------------------------
    $scope.checkImperfectScore = function () {
        $('#notice_exam_score').hide();

        $scope.completeImperfectScore = false;
        if ($.isNumeric($scope.imperfectScore) && $scope.imperfectScore.indexOf('.') < 0 && $scope.imperfectScore >= 0) {
            $scope.completeImperfectScore = true;
        } else {
            $('#notice_exam_score').html('* กรุณาระบุเฉพาะจำนวนเต็มบวกเท่านั้น').show();
        }
    };

    //----------------------------------------------------------------------
    $scope.checkCutWrongAnswer = function () {
        $('#notice_exam_descore').hide();

        $scope.completeCutWrongAnswer = false;
        if ($.isNumeric($scope.cutWrongAnswer)) {
            $scope.completeCutWrongAnswer = true;
        } else {
            $('#notice_exam_descore').html('* กรุณาระบุการหักคะแนนคำตอบผิดพลาดให้ถูกต้อง').show();
        }
    };
    //----------------------------------------------------------------------
    $scope.checkCutComplieError = function () {
        $('#notice_exam_descore').hide();

        $scope.completeCutComplieError = false;
        if ($.isNumeric($scope.cutComplieError)) {
            $scope.completeCutComplieError = true;
        } else {
            $('#notice_exam_descore').html('* กรุณาระบุการหักคะแนนรูปแบบโค้ดไม่ถูกต้อง ให้ถูกต้อง').show();
        }
    };
    //----------------------------------------------------------------------
    $scope.checkCutOverMem = function () {
        $('#notice_exam_descore').hide();

        $scope.completeCutOverMem = false;
        if ($.isNumeric($scope.cutOverMem)) {
            $scope.completeCutOverMem = true;
        } else {
            $('#notice_exam_descore').html('* กรุณาระบุการหักคะแนนหน่วยความจำเกินให้ถูกต้อง').show();
        }
    };
    //----------------------------------------------------------------------
    $scope.checkCutOverTime = function () {
        $('#notice_exam_descore').hide();

        $scope.completeCutOverTime = false;
        if ($.isNumeric($scope.cutOverTime)) {
            $scope.completeCutOverTime = true;
        } else {
            $('#notice_exam_descore').html('* กรุณาระบุการหักคะแนนเวลาประมวณผลเกินให้ถูกต้อง').show();
        }
    };

    //----------------------------------------------------------------------
    $scope.copyExam = function () {
        $('#notice_exam_descore').hide();
        $('#notice_exam_score').hide();
        $('#notice_exam_limit').hide();
        $('#notice_exam_main_input').hide();
        $('#notice_exam_txt_output').hide();
        $('#notice_exam_file_output').hide();
        $('#notice_exam_txt_input').hide();
        $('#notice_exam_file_input').hide();
        $('#notice_exam_content').hide();
        $('#notice_exam_name').hide();
        $('#notice_section').hide();
        $scope.completeExamName = $scope.examName.length > 0;
        if ($scope.completeExamName) {
            $scope.completeNoDuplicate = findExamByName($scope.examName,$('#ddl_group').val(),myuser.id);
        }
        $scope.completeExamContent = $('#exam_content').Editor("getText").length > 0;
        $scope.completeSelectSection = $('#ddl_group').val() === '0' ? false : true ;
        $scope.completeInputMode = $scope.inputMode === 'no_input' ? true :
            $scope.inputMode === 'key_input' ? ($scope.input === '' ? false : true) :
                $scope.inputMode === 'file_input' ? ($('[name=exam_file_input]').val() === '' ? false : checkTxtFile($('[name=exam_file_input]').val())) : false;
        $scope.completeOutputMode = $scope.outputMode === 'key_output' ? ($scope.output === '' ? false : true) :
            $scope.outputMode === 'file_output' ? ($('[name=exam_file_output]').val() === '' ? false : checkTxtFile($('[name=exam_file_output]').val())) : false;
        $scope.completeClassTest = $scope.classTestMode === '0' ? true :
            $scope.classTestMode === '1' ? ($scope.main === '' ? false : true) : false;

        if ($scope.completeExamName
            && $scope.completeNoDuplicate
            && $scope.completeSelectSection
            && $scope.completeExamContent
            && $scope.completeInputMode
            && $scope.completeOutputMode
            && $scope.completeClassTest
            && $scope.completeMemLimit
            && $scope.completeTimeLimit
            && $scope.completeFullScore
            && $scope.completeImperfectScore
            && $scope.completeCutWrongAnswer
            && $scope.completeCutComplieError
            && $scope.completeCutOverMem
            && $scope.completeCutOverTime) {

            $('#copy_exam_part').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });

            createContentFile(escapeHtml($('#exam_content').Editor("getText")), function (content_part) {
                $scope.contentPart = content_part;
                if ($scope.inputMode === 'no_input') {
                    $scope.inputPart = "";
                } else if ($scope.inputMode === 'key_input') {
                    $scope.inputPart = createTextFile($scope.input, "input");
                } else {
                    $('#inputFileForm').submit();
                    $scope.inputPart = $window.input_part;
                }

                if ($scope.outputMode === 'key_output') {
                    $scope.outputPart = createTextFile($scope.output, "output");
                } else {
                    $('#outputFileForm').submit();
                    $scope.outputPart = $window.output_part;
                }
                getKeyword();
                data = {
                    user_id: $window.myuser.id,
                    section_id: $('#ddl_group').val(),
                    exam_name: $scope.examName,
                    exam_data: $scope.contentPart,
                    exam_inputfile: $scope.inputPart,
                    exam_outputfile: $scope.outputPart,
                    memory_size: $scope.memLimit,
                    time_limit: $scope.timeLimit,
                    full_score: $scope.fullScore,
                    accep_imperfect: $scope.imperfectScore,
                    cut_wrongans: $scope.cutWrongAnswer,
                    cut_comerror: $scope.cutComplieError,
                    cut_overmemory: $scope.cutOverMem,
                    cut_overtime: $scope.cutOverTime,
                    main_code: $scope.main,
                    case_sensitive: $scope.classTestMode,
                    keyword: newKeywords,
                };
                if($scope.selectTeacher.length>0){
                    data.shared = $scope.selectTeacher;
                } else {
                    var share = new Array();
                    data.shared = share;
                }
                // createExam(data);
            });

        } else {
            if (!$scope.completeCutOverTime) {
                $('#notice_exam_descore').html('* กรุณาระบุข้อมูลการหักคะแนนให้ครบถ้วนและถูกต้อง').show();
                $('[ng-model=cutOverTime]').focus();
            }
            if (!$scope.completeCutOverMem) {
                $('#notice_exam_descore').html('* กรุณาระบุข้อมูลการหักคะแนนให้ครบถ้วนและถูกต้อง').show();
                $('[ng-model=cutOverMem]').focus();
            }
            if (!$scope.completeCutComplieError) {
                $('#notice_exam_descore').html('* กรุณาระบุข้อมูลการหักคะแนนให้ครบถ้วนและถูกต้อง').show();
                $('[ng-model=cutComplieError]').focus();
            }
            if (!$scope.completeCutWrongAnswer) {
                $('#notice_exam_descore').html('* กรุณาระบุข้อมูลการหักคะแนนให้ครบถ้วนและถูกต้อง').show();
                $('[ng-model=cutWrongAnswer]').focus();
            }

            if (!$scope.completeImperfectScore) {
                $('#notice_exam_score').html('* กรุณาระบุข้อมูลการให้คะแนนให้ครบถ้วนสมบูรณ์').show();
                $('[ng-model=imperfectScore]').focus();
            }
            if (!$scope.completeFullScore) {
                $('#notice_exam_score').html('* กรุณาระบุข้อมูลการให้คะแนนให้ครบถ้วนสมบูรณ์').show();
                $('[ng-model=fullScore]').focus();
            }

            if (!$scope.completeTimeLimit) {
                $('#notice_exam_limit').html('* กรุณาระบุข้อมูลข้อจำกัดให้ครบถ้วนสมบูรณ์').show();
                $('[ng-model=timeLimit]').focus();
            }
            if (!$scope.completeMemLimit) {
                $('#notice_exam_limit').html('* กรุณาระบุข้อมูลข้อจำกัดให้ครบถ้วนสมบูรณ์').show();
                $('[ng-model=memLimit]').focus();
            }

            if (!$scope.completeClassTest) {
                $('#notice_exam_main_input').html('* กรุณาระบุ method main ของข้อสอบ').show();
                $('[ng-model=main]').focus();
            }

            if (!$scope.completeOutputMode) {
                if ($scope.outputMode === 'key_output') {
                    $('#notice_exam_txt_output').html('* กรุณาระบุ Output ของข้อสอบ').show();
                    $('[ng-model=output]').focus();
                } else {
                    if ($('[name=exam_file_output]').val() === '') {
                        $('#notice_exam_file_output').html('* กรุณาระบุไฟล์ Output ของข้อสอบ').show();
                    } else {
                        $('#notice_exam_file_output').html('* กรุณาระบุไฟล์ .txt เท่านั้น').show();
                    }
                    $('[name=exam_file_output]').focus();
                }
            }
            if (!$scope.completeInputMode) {
                if ($scope.inputMode === 'key_input') {
                    $('#notice_exam_txt_input').html('* กรุณาระบุ Input ของข้อสอบ').show();
                    $('[ng-model=input]').focus();
                } else {
                    if ($('[name=exam_file_input]').val() === '') {
                        $('#notice_exam_file_input').html('* กรุณาระบุไฟล์ Input ของข้อสอบ').show();
                    } else {
                        $('#notice_exam_file_input').html('* กรุณาระบุไฟล์ .txt เท่านั้น').show();
                    }
                    $('[name=exam_file_input]').focus();
                }
            }

            if (!$scope.completeExamName) {
                $scope.completeNoDuplicate = true;
                $('#notice_exam_name').html('* กรุณาระบุชื่อข้อสอบ').show();
                $('[ng-model=examName]').focus();
            }

            if (!$scope.completeNoDuplicate) {
                $('#notice_exam_name').html('* ข้อสอบนี้มีอยู่แล้ว').show();
                $('[ng-model=examName]').focus();
            }

            if (!$scope.completeSelectSection) {
                $('#notice_section').html('* กรุณาเลือกกลุ่มข้อสอบ').show();
                $('[ng-model=groupId]').focus();
            }
        }
    };
    //----------------------------------------------------------------------
    $('#okSuccess').on('click',function () {
        window.location.href = url+'/myExam';
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

    function decapeHtml(str) {
        str = str.replace(/&amp;/g, '&');
        str = str.replace(/&lt;/g, '<');
        str = str.replace(/&gt;/g, '>');
        str = str.replace(/&quot;/g, '"');
        str = str.replace(/&#39;/g, "'");
        str = str.replace(/&#x2F;/g, '/');
        return str;
    }

    //----------------------------------------------------------------------
    function getExtension(filename) {
        var parts = filename.split('.');
        return parts[parts.length - 1];
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

    //----------------------------------------------------------------------
    function getKeyword() {
        newKeywords = new Array();
        $('[id^=old_keyword_]').each(function () {
            if (this.value.length > 0)
                newKeywords.push(this.value);
        });
        $('[id^=exam_keyword_]').each(function () {
            if (this.value.length > 0)
                newKeywords.push(this.value);
        });
    }

    //----------------------------------------------------------------------
    function createContentFile(content, callback) {
        $.post("../public/js/Components/Contentfile.php", {
            Content: content
        }, function (data) {
            callback(data);
        });
    }
    //----------------------------------------------------------------------
    $scope.goBack = function () {
        window.history.back();
    }
    //----------------------------------------------------------------------
    $scope.addUserShare = function () {

        $('#add_user_to_share_modal').modal({backdrop: 'static'});
        // setTimeout(function () {
        //     $('[ng-model=examGroupName]').focus();
        // }, 200);
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
    });
    //----------------------------------------------------------------------
}]);



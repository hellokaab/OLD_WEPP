app.controller('examCtrl', ['$scope', '$window', function ($scope, $window) {
        $scope.thisUser = $window.myuser;
        $scope.exams = $window.exams;
        // $scope.allSection = $window.allsections;
        $scope.sectionSharedToMe = findSectionSharedNotMe($window.myuser.id);
        $scope.examShareToMe = findExamSharedToMe($window.myuser.id);
        // $scope.mySection = $window.mysections;
        // $scope.teacherId = $window.user_id;
        $scope.queryBy = 'section_name';
        $scope.selectRow = '10';
        $scope.groupId = 0;
        $scope.sortS = 'section_name';
        $scope.sortC = 'creater';
        $('#exam_content').Editor();

        //----------------------------------------------------------------------
        $scope.changeGroup = function (data) {
            $scope.groupId = data.id;
            $('#divExamList').removeAttr('style');
        };
        //----------------------------------------------------------------------
        $scope.detailExam = function (data) {
            $scope.examId = data.id;
            $scope.createrID = data.user_id;
            $('#examName').html(data.exam_name);
            $('#examTimeLimit').html(data.time_limit);
            $('#examMemLimit').html(data.memory_size);

            $('#fullScore').html(data.full_score);
            $('#imperfect').html(data.accep_imperfect);
            $('#cutWrongAnswer').html(data.cut_wrongans);
            $('#cutComplieError').html(data.cut_comerror);
            $('#cutOverMem').html(data.cut_overmemory);
            $('#cutOverTime').html(data.cut_overtime);
            // $('#list_keyword').children().remove();
            $scope.keywords = findKeywordByEID(data.id);
            // console.log($scope.keywords);

            // $('#edit_exam').attr('href', 'editExam.php?id=' + data.exam_id);
            $('#detail_exam_modal').modal({backdrop: 'static'});

            $('.Editor-editor').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });
            $('#input_part').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });
            $('#output_part').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });

            var fileData = readFile(data).responseJSON;
            $('#exam_content').Editor('setText', decapeHtml(fileData.content));
            $('.Editor-editor').attr('contenteditable', false);
            $('[id^=menuBarDiv]').hide();
            $('[id^=statusbar]').hide();
            $('#examInput').html(fileData.input);
            $('#examOutput').html(fileData.output);
            //
            $('.Editor-editor').waitMe('hide');
            $('#input_part').waitMe('hide');
            $('#output_part').waitMe('hide');

            //     $('#list_keyword').children().remove();
            //
            //     for (i = 0; i < res.keyword.length; i++)
            //         $('#list_keyword').append('<li>' + res.keyword[i] + '</li>');
            // });
        };
        //----------------------------------------------------------------------
        $scope.editExam = function () {
           window.location.href = url+"/editExam"+$scope.examId;
        };
        //----------------------------------------------------------------------
        $scope.copyExam = function (data) {
            window.location.href = url+"/copyExam"+data.id;
        };
        //----------------------------------------------------------------------
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
        $scope.findCreater = function (section) {
            var name = findCreaterByPID(section.personal_id);
            return name;
        };
        //----------------------------------------------------------------------
        $scope.changePlaceholder  = function (section) {
            if($scope.queryBy === 'section_name'){
                $('#txt_search')[0].placeholder = "ชื่อกลุ่มข้อสอบ";
            } else if($scope.queryBy === 'creater'){
                $('#txt_search')[0].placeholder = "ชื่อผู้สร้างกลุ่มข้อสอบ";
            }
        };
        //----------------------------------------------------------------------
        $scope.sort = function(keyname){
            $scope.sortKey = keyname;   //set the sortKey to the param passed
            if($scope.sortKey === 'section_name'){
                $scope.reverseS = !$scope.reverseS; //if true make it false and vice versa
                if($scope.sortS === 'section_name'){
                    $scope.sortS = '-section_name';
                } else {
                    $scope.sortS = 'section_name';
                }
            } else {
                $scope.reverseC = !$scope.reverseC; //if true make it false and vice versa
                if($scope.sortC === 'creater'){
                    $scope.sortC = '-creater';
                } else {
                    $scope.sortC = 'creater';
                }
            }
        };
        //----------------------------------------------------------------------
    }]);



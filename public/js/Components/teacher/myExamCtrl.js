app.controller('myExamCtrl', ['$scope', '$window', function ($scope, $window) {
        $scope.thisUser = $window.myuser;
        $scope.exams = $window.exams;
        // $scope.allSection = $window.allsections;
        $scope.mySection = $window.mysections;

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
        $scope.addExamGroup = function () {
            $scope.examGroupName = '';
            $('#notice_add_exam_grp').hide();
            $('#add_exam_group_modal').modal({backdrop: 'static'});
            setTimeout(function () {
                $('[ng-model=examGroupName]').focus();
            }, 200);
        };
        //----------------------------------------------------------------------
        $scope.enterAdd = function() {
            $scope.okAddExamGroup();
        };
        //----------------------------------------------------------------------
        $scope.okAddExamGroup = function () {
            if ($scope.examGroupName.length > 0) {
                $('#add_exam_group_part').waitMe({
                    effect: 'facebook',
                    bg: 'rgba(255,255,255,0.9)',
                    color: '#3bafda'
                });
                var data = {
                    user_id : $scope.thisUser.id,
                    section_name: $scope.examGroupName
                };
                createSection(data);
            } else {
                $('#notice_add_exam_grp').html('* กรุณาระบุชื่อกลุ่มข้อสอบ').show();
            }
        };
        //----------------------------------------------------------------------
        $scope.editExamGroup = function (data) {
            $scope.CurrentIndex = $scope.mySection.indexOf(data);
            $scope.examGroupName = data.section_name;
            $scope.groupId = data.id;
            $('#notice_edit_exam_grp').hide();
            $('#edit_exam_group_modal').modal({backdrop: 'static'});
            setTimeout(function () {
                $('[ng-model=examGroupName]').focus();
            }, 200);
        };
        //----------------------------------------------------------------------
        $scope.okEditExamGroup = function () {
            if ($scope.examGroupName.length > 0) {
                var data = {
                    id : $scope.groupId,
                    section_name: $scope.examGroupName,
                    user_id : $window.myuser.id
                };
                $('#edit_exam_group_part').waitMe({
                    effect: 'facebook',
                    bg: 'rgba(255,255,255,0.9)',
                    color: '#3bafda'
                });
                editSection(data);
            } else {
                $('#notice_edit_exam_grp').html('* กรุณาระบุชื่อกลุ่มข้อสอบ').show();
            }
        };
        //----------------------------------------------------------------------
        $scope.deleteExamGroup = function (data) {
            $scope.examGroupName = data.section_name;
            $scope.groupId = data.id;
            $('#delete_exam_group_modal').modal({backdrop: 'static'});
        };
        //----------------------------------------------------------------------
        $scope.okDeleteExamGroup = function () {
            var data = {
                id : $scope.groupId
            };
            $('#delete_exam_group_part').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });
            deleteSection(data);
        };
        //----------------------------------------------------------------------
        $scope.addExam = function () {
            window.location.href = url+"/addExam"+$scope.groupId;
        };
        //----------------------------------------------------------------------
        $scope.gotoEditExam = function (data) {
            window.location.href = url+"/editExam"+data.id;
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
        $scope.deleteExam = function (data) {
            $scope.examName = data.exam_name;
            $scope.examId = data.id;
            $('#delete_exam_modal').modal({backdrop: 'static'});
        };
        //----------------------------------------------------------------------
        $scope.okDelete = function () {
            $('#edit_exam_part').waitMe({
                effect: 'facebook',
                bg: 'rgba(255,255,255,0.9)',
                color: '#3bafda'
            });
            daleteExam($scope.examId);
        };
        //----------------------------------------------------------------------
        $('#okSuccess').on('click',function () {
            window.location.href = url+'/myExam';
        });
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



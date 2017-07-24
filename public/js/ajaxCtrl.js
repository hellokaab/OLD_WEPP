/**
 * Created by Pongpan on 15-Jun-17.
 */
function findUserByPersonalID() {
    var user = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findByPersonalID',
        data: mysession,
        async: false,
    });
    return user;
}

function addUser() {
    var user = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/user',
        data: mysession,
        async: false,
    });
    return user;
}

function findAllExam() {
    var exam = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findAllExam',
        async: false,
    });
    return exam;
}

function findAllSection() {
    var section = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findAllSection',
        async: false,
    });
    return section;
}

function findMySection(data) {
    var section = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findMySection',
        data:data,
        async: false,
    });
    return section;
}

function createSection(data) {
    $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/section/save',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    $('#add_exam_group_part').waitMe('hide');
                    alert("สำเร็จ");
                    window.location.href = url+'/myExam';
                } else if (xhr.status == 209){
                    $('#add_exam_group_part').waitMe('hide');
                    $('#notice_add_exam_grp').html('* กลุ่มข้อสอบนี้มีอยู่แล้ว').show();
                    $('[ng-model=examGroupName]').focus();
                } else {
                    $('#add_exam_group_part').waitMe('hide');
                    alert("ผิดพลาด");
                }
            }
        }
    });
}

function editSection(data) {
    $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/section/edit',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    $('#edit_exam_group_part').waitMe('hide');
                    alert("สำเร็จ");
                    location.reload();
                    // $scope.groups[$scope.CurrentIndex].section_name = $scope.examGroupName;
                } else if (xhr.status == 209){
                    $('#edit_exam_group_part').waitMe('hide');
                    $('#notice_edit_exam_grp').html('* กลุ่มข้อสอบนี้มีอยู่แล้ว').show();
                    $('[ng-model=examGroupName]').focus();
                } else {
                    $('#edit_exam_group_part').waitMe('hide');
                    alert("ผิดพลาด");
                }
            }
        }
    });
}

function deleteSection(data) {
    $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/section/delete',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    $('#delete_exam_group_part').waitMe('hide');
                    alert("ลบสำเร็จ");
                    location.reload();
                }  else {
                    $('#delete_exam_group_part').waitMe('hide');
                    alert("ผิดพลาด");
                }
            }
        }
    });
}

function findExamByName(data,section_id,user_id) {
    var checked = false;
    $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/checkExamByName',
        data: {
            exam_name :data,
            user_id :user_id,
            sections_id:section_id
        },
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    checked = true;
                }
            }
        }
    });
    return checked;
}

function createTextFile(data,status) {
    var part = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/createTextFile',
        data:{
            content:data,
            status:status
        },
        async: false,
    }).responseJSON;
    return part;
}

function createExam(data) {
    var createExamSuccess = false;
    var createKeywordSuccess = false;
    var exam = $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/createExam',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    createExamSuccess = true;
                    // $('#add_exam_part').waitMe('hide');
                    // alert("สำเร็จ");
                    // window.location.href = url+'/exam';
                } else {
                    $('#add_exam_part').waitMe('hide');
                    alert("ผิดพลาด");
                }

            }
        }
    }).responseJSON;
    if (createExamSuccess) {
        for (i = 0; i < data.keyword.length; i++) {
            createKeyword(exam.id, data.keyword[i]);
        }
        createSharedExam(exam.id,data.user_id);
        for (i = 0; i < data.shared.length; i++) {
            createSharedExam(exam.id, data.shared[i].id);
        }
        $('#add_exam_part').waitMe('hide');
        alert("สำเร็จ");
        window.location.href = url+'/myExam';
    }

}

function updateExam(data) {
    var createExamSuccess = false;
    $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/updateExam',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    createExamSuccess = true;
                    // $('#edit_exam_part').waitMe('hide');
                    // alert("สำเร็จ");
                    // window.location.href = url+'/exam';
                } else {
                    $('#edit_exam_part').waitMe('hide');
                    alert("ผิดพลาด");
                }

            }
        }
    });
    if (createExamSuccess) {
        for (i = 0; i < data.keyword.length; i++) {
            createKeyword(data.id, data.keyword[i]);
        }
        for (i =0; i < data.deleteShared.length;i++){
            deleteUserShared(data.id,data.deleteShared[i]);
        }
        for (i = 0; i < data.shared.length;i++){
            updateSharedExam(data.id,data.shared[i].id);
        }
        $('#edit_exam_part').waitMe('hide');
        alert("สำเร็จ");
        window.location.href = url+'/myExam';
    }
}

function deleteSectionGroup(data) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/Group/delete',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    $('#delete_group_part').waitMe('hide');
                    alert("ลบสำเร็จ");
                    location.reload();
                } else {
                    $('#delete_group_part').waitMe('hide');
                    alert("ผิดพลาด");
                }
            }
        }
    });
}

function readFile(data) {
    var test = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/readFile',
        data: data,
        async: false,
    });
    return test;
}

function daleteExam(data) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/deleteExam/'+data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    $('#delete_exam_part').waitMe('hide');
                    alert("ลบสำเร็จ");
                    location.reload();
                } else {
                    $('#delete_exam_part').waitMe('hide');
                    alert("ผิดพลาด");
                }
            }
        }
    });
}

function findExamByID(data) {
    var exam = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findExamByID/'+data,
        async: false,
    });
    return exam;
}

function createKeyword(examID,keyword) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/createKeyword',
        data:{exam_id:examID,keyword:keyword},
        async: false,
    });

}

function findKeywordByEID(EID) {
    var keyword = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findKeywordByEID',
        data:{exam_id:EID},
        async: false,
    }).responseJSON;
    return keyword;
}

function findAllGroup() {
    var groupData = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findAllGroup',
        async: false,
    });
    return groupData;
}

function findMyGroup(data) {
    var groupMyData = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findMyGroup',
        data: data,
        async: false,
    });
    return groupMyData;
}

function findTeacher() {
    var teacher = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findTeacher',
        async: false,
    }).responseJSON;
    return teacher;
}

function createSharedExam(examID,userID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/createSharedExam',
        data:{exam_id:examID,user_id:userID},
        async: false,
    });
}

function findSharedUserNotMe(EID,MyID) {
    var shared = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSharedUserNotMe',
        data:{exam_id:EID,my_id:MyID},
        async: false,
    }).responseJSON;
    return shared;
}

function deleteUserShared(EID,UID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/deleteUserShared',
        data:{exam_id:EID,user_id:UID},
        async: false,
    });
}

function updateSharedExam(examID,userID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/updateSharedExam',
        data:{exam_id:examID,user_id:userID},
        async: false,
    });
}

function findSectionSharedToMe(MyID) {
    var sectionSharedToMe = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSectionSharedToMe',
        data:{my_id:MyID},
        async: false,
    }).responseJSON;
    return sectionSharedToMe
}

function findSectionSharedNotMe(MyID) {
    var sectionSharedNotMe = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSectionSharedNotMe',
        data:{my_id:MyID},
        async: false,
    }).responseJSON;
    return sectionSharedNotMe
}

function findExamSharedToMe(MyID) {
    var examSharedToMe = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findExamSharedToMe',
        data:{my_id:MyID},
        async: false,
    }).responseJSON;
    return examSharedToMe
}
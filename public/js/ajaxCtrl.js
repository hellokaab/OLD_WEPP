/**
 * Created by Pongpan on 15-Jun-17.
 */

//--------------------------- UserController ---------------------------

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

function findUserByID(UID) {
    var user = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findUserByID',
        data: {id:UID},
        async: false,
    }).responseJSON;
    return user;
}

//--------------------------- GroupController ---------------------------

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
                    $('#delete_grp_modal').modal('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                } else {
                    $('#delete_group_part').waitMe('hide');
                    $('#delete_grp_modal').modal('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }
            }
        }
    });
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

function findGroupDataByID(id) {
    var groupData = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findGroupDataByID',
        data: {id: id},
        async: false,
    }).responseJSON;
    return groupData;

}

//--------------------------- SectionController ---------------------------

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
                    $('#add_exam_group_modal').modal('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                } else if (xhr.status == 209){
                    $('#add_exam_group_part').waitMe('hide');
                    $('#notice_add_exam_grp').html('* กลุ่มข้อสอบนี้มีอยู่แล้ว').show();
                    $('[ng-model=examGroupName]').focus();
                } else {
                    $('#add_exam_group_part').waitMe('hide');
                    $('#add_exam_group_modal').modal('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
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
                    $('#edit_exam_group_modal').modal('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                } else if (xhr.status == 209){
                    $('#edit_exam_group_part').waitMe('hide');
                    $('#notice_edit_exam_grp').html('* กลุ่มข้อสอบนี้มีอยู่แล้ว').show();
                    $('[ng-model=examGroupName]').focus();
                } else {
                    $('#edit_exam_group_part').waitMe('hide');
                    $('#edit_exam_group_modal').modal('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
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
                    $('#delete_exam_group_modal').modal('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                }  else {
                    $('#delete_exam_group_part').waitMe('hide');
                    $('#delete_exam_group_modal').modal('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }
            }
        }
    });
}

//--------------------------- ExamController ---------------------------

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

function findExamByName(data,section_id,user_id) {
    var checked = false;
    var test = $.ajax ({
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
    }).responseJSON;
    return checked;
}

function createTextFile(data,status,path) {
    var path = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/createTextFile',
        data:{
            content:data,
            status:status,
            path:path
        },
        async: false,
    }).responseJSON;
    return path;
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
                    $('#unsuccess_modal').modal({backdrop: 'static'});
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
        $('#success_modal').modal({backdrop: 'static'});
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
                    $('#unsuccess_modal').modal({backdrop: 'static'});
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
        $('#success_modal').modal({backdrop: 'static'});
    }
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
                    $('#delete_exam_modal').modal('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                } else {
                    $('#delete_exam_part').waitMe('hide');
                    $('#delete_exam_modal').modal('hide');
                    $('#success_modal').modal({backdrop: 'static'});
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
    }).responseJSON;
    return exam;
}

function readExamContent(data) {
    var test = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/readExamContent',
        data: data,
        async: false,
    }).responseJSON;
    return test;
}

//--------------------------- ShareExamController ---------------------------

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

//--------------------------- KeywordController ---------------------------

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

//--------------------------- ExamingController ---------------------------

function createExaming(data) {
    var createExamingSuccess = false;
    var examing = $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/createExaming',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    createExamingSuccess = true;
                    // $('#add_exam_part').waitMe('hide');
                    // alert("สำเร็จ");
                    // window.location.href = url+'/exam';
                } else {
                    $('#open_exam_part').waitMe('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }

            }
        }
    }).responseJSON;
    if (createExamingSuccess) {
        for(i=0;i<data.exam.length;i++){
            createExamExaming(parseInt(data.exam[i]),examing.id);
        }
        $('#open_exam_part').waitMe('hide');
        $('#success_modal').modal({backdrop: 'static'});
    }

}

function updateExaming(data) {
    var updateExamingSuccess = false;
    $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/updateExaming',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    updateExamingSuccess = true;
                    // $('#add_exam_part').waitMe('hide');
                    // alert("สำเร็จ");
                    // window.location.href = url+'/exam';
                } else {
                    $('#edit_examing_part').waitMe('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }

            }
        }
    });
    if (updateExamingSuccess) {
        for(i=0;i<data.deleteExamExaming.length;i++){
            daleteExamExaming(data.deleteExamExaming[i],data.id) ;
        }
        for(i=0;i<data.exam.length;i++){
            updateExamExaming(data.exam[i],data.id);
        }
        $('#edit_examing_part').waitMe('hide');
        $('#success_modal').modal({backdrop: 'static'});
    }

}

function findExamingByNameAndGroup(name,GID) {
    var checked = false;
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findExamingByNameAndGroup',
        data:{examing_name:name,group_id:GID},
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

function findExamingByUserID(UID) {
    var examing = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findExamingByUserID',
        data:{user_id:UID},
        async: false,
    }).responseJSON;
    return examing;
}

function deleteExaming(EMID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/deleteExaming',
        data:{id:EMID},
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    $('#delete_part').waitMe('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                }  else {
                    $('#delete_part').waitMe('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }
            }
        }
    });
}

function findExamingByID(EMID) {
    var examing = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findExamingByID',
        data:{id:EMID},
        async: false,
    }).responseJSON;
    return examing;
}

function findSTDExamingItsComing(GID) {
    var examing = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSTDExamingItsComing',
        data:{group_id:GID},
        async: false,
    }).responseJSON;
    return examing;
}

function findExamingItsComing(GID) {
    var examing = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findExamingItsComing',
        data:{group_id:GID},
        async: false,
    }).responseJSON;
    return examing;
}

function findExamingItsEnding(GID) {
    var examing = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findExamingItsEnding',
        data:{group_id:GID},
        async: false,
    }).responseJSON;
    return examing;
}

//--------------------------- ExamExamingController ---------------------------

function createExamExaming(examID,examingID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/createExamExaming',
        data:{exam_id:examID,examing_id:examingID},
        async: false,
    });
}

function findExamExamingByExamingID(EMID) {
    var examExaming =  $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findExamExamingByExamingID',
        data:{examing_id:EMID},
        async: false,
    }).responseJSON;
    return examExaming
}

function updateExamExaming(examID,examingID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/updateExamExaming',
        data:{exam_id:examID,examing_id:examingID},
        async: false,
    });
}

function daleteExamExaming(examID,examingID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/daleteExamExaming',
        data:{exam_id:examID,examing_id:examingID},
        async: false,
    });

}

function findExamExamingInViewExam(EMID,UID) {
    var examExaming =  $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findExamExamingInViewExam',
        data:{examing_id:EMID,user_id:UID},
        async: false,
    }).responseJSON;
    return examExaming
}


//--------------------------- JoinGroupController ---------------------------

function checkJoinGroup(UID,GID) {
    var checker = true
    var test = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/checkJoinGroup',
        data:{user_id:UID,group_id:GID},
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    checker = true;
                }  else {
                    checker = false;
                }
            }
        }
    });
    console.log(test);
    return checker;
}

function createJoinGroup(UID,GID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/createJoinGroup',
        data:{user_id:UID,group_id:GID},
        async: false,
    });
}

function findMemberGroup(GID) {
    var member = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findMemberGroup',
        data:{group_id:GID},
        async: false,
    }).responseJSON;
    return member;
}

function exitGroup(UID,GID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/exitGroup',
        data:{user_id:UID,group_id:GID},
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    window.location.href = url+'/stdGroup';
                }  else {
                    $('#join_group_part').waitMe('hide');
                    alert("ผิดพลาด");
                }
            }
        }
    });
}

function findMyJoinGroup(UID) {
    var myGroup = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findMyJoinGroup',
        data:{user_id:UID},
        async: false,
    }).responseJSON;
    return myGroup
}

function managePermissions(data) {
    var JG = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/managePermissions',
        data:data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    location.reload();
                }  else {
                    alert("ผิดพลาด");
                }
            }
        }
    }).responseJSON;
    return JG;
};

function findMyPermissionsInGroup(UID,GID) {
    var myGroup = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findMyPermissionsInGroup',
        data:{user_id:UID,group_id:GID},
        async: false,
    }).responseJSON;
    return myGroup
}

//--------------------------- WorkSheetController ---------------------------

function addMyWorksheetGroup(data) {
    $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/addMyWorksheetGroup',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    $('#addWorkSheetGroupPart').waitMe('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                } else if (xhr.status == 209){
                    $('#addWorkSheetGroupPart').waitMe('hide');
                    $('#notice_name_add_mwsg').html('* กลุ่มใบงานนี้มีอยู่แล้ว').show();
                    $('[ng-model=MySheetName]').focus();
                } else {
                    $('#addWorkSheetGroupPart').waitMe('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }
            }
        }
    });
}

function findMySheetGroup(data) {
    var dataSheet = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findMySheetGroup',
        data: data,
        async: false,
    });
    return dataSheet;
}

function deleteWorksheetGroup(data) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/delete/groupSheet',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    $('#delete_WorksheetGroup_part').waitMe('hide');
                    $('#delete_wsg_modal').modal('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                } else {
                    $('#delete_WorksheetGroup_part').waitMe('hide');
                    $('#delete_wsg_modal').modal('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }
            }
        }
    });
}

function editWorksheetGroup(data) {
    $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/edit/groupSheet',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    $('#edit_worksheet_group_part').waitMe('hide');
                    $('#edit_worksheet_group_modal').modal('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                } else if (xhr.status == 209){
                    $('#edit_worksheet_group_part').waitMe('hide');
                    $('#notice_edit_worksheetGroup_ewsg').html('* กลุ่มใบงานนี้มีอยู่แล้ว').show();
                    $('[ng-model=MySheetName]').focus();
                } else {
                    $('#edit_worksheet_group_part').waitMe('hide');
                    $('#edit_worksheet_group_modal').modal('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }
            }
        }
    });
}

function findSheetByName(data,sheet_group_id,user_id) {
    var checked = false;
    var test = $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findSheetByName',
        data: {
            sheet_name :data,
            user_id :user_id,
            sheet_group_id:sheet_group_id
        },
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    checked = true;
                }
            }
        }
    }).responseJSON;
    return checked;
}

function createWorksheet(data) {
    var createSheetSuccess = false;
    var sheet = $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/createWorksheet',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    createSheetSuccess = true;
                } else {
                    $('#add_sheet_part').waitMe('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }

            }
        }
    }).responseJSON;
    if (createSheetSuccess) {
        for (i = 0; i < data.quiz.length; i++) {
            createQuiz(sheet.id, data.quiz[i]);
        }
        createSharedWorksheet(sheet.id,data.user_id);
        for (i = 0; i < data.shared.length; i++) {
            createSharedWorksheet(sheet.id, data.shared[i].id);
        }
        $('#add_sheet_part').waitMe('hide');
        $('#success_modal').modal({backdrop: 'static'});
    }

}

function updateWorksheet(data) {
    var createSheetSuccess = false;
    var sheet = $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/updateWorksheet',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    createSheetSuccess = true;
                } else {
                    $('#add_sheet_part').waitMe('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }

            }
        }
    }).responseJSON;
    if (createSheetSuccess) {
        for (i = 0; i < data.quiz.length; i++) {
            createQuiz(data.id, data.quiz[i]);
        }
        for (i =0; i < data.deleteShared.length;i++){
            deleteUserSharedSheet(data.id,data.deleteShared[i]);
        }
        for (i = 0; i < data.shared.length; i++) {
            updateSharedSheet(data.id, data.shared[i].id);
        }
        $('#add_sheet_part').waitMe('hide');
        $('#success_modal').modal({backdrop: 'static'});
    }

}

function deleteUserSharedSheet(SHID,UID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/deleteUserSharedSheet',
        data:{sheet_id:SHID,user_id:UID},
        async: false,
    });
}

function updateSharedSheet(SHID,userID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/updateSharedSheet',
        data:{sheet_id:SHID,user_id:userID},
        async: false,
    });
}

function findSheetByUserID(UID) {
    var sheets = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findSheetByUserID',
        data:{user_id:UID},
        async: false,
    }).responseJSON;
    return sheets;
}

function findSheetByID(ID) {
    var sheets = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findSheetByID',
        data:{id:ID},
        async: false,
    }).responseJSON;
    return sheets;
}

function createQuiz(sheetID,quiz) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/createQuiz',
        data:{
            sheet_id:sheetID,
            quiz_data:quiz.quiz,
            quiz_ans:quiz.answer,
            quiz_score:quiz.score,
        },
        async: false,
    });

}

function createSharedWorksheet(sheetID,userID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/createSharedWorksheet',
        data:{sheet_id:sheetID,user_id:userID},
        async: false,
    });
}

function findWorksheetByID(data) {
    var worksheet = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findWorksheetByID'+data,
        async: false,
    }).responseJSON;
    return worksheet;
}

function readFileSh(data) {
    var test = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/readFileSh',
        data: data,
        async: false,
    }).responseJSON;
    return test;
}

function findSheetSharedUserNotMe(SHID,MyID) {
    var shared = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSheetSharedUserNotMe',
        data:{sheet_id:SHID,my_id:MyID},
        async: false,
    }).responseJSON;
    return shared;
}

function deleteWorksheet(data) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/deleteWorksheet'+data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    $('#delete_sheet_part').waitMe('hide');
                    $('#delete_sheet_modal').modal('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                } else {
                    $('#delete_sheet_part').waitMe('hide');
                    $('#delete_sheet_modal').modal('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                }
            }
        }
    });
}

function findSheetGroupSharedToMe(MyID) {
    var sheetGroupSharedToMe = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSheetGroupSharedToMe',
        data:{my_id:MyID},
        async: false,
    }).responseJSON;
    return sheetGroupSharedToMe
}

function findSheetGroupSharedNotMe(MyID) {
    var sheetGroupSharedNotMe = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSheetGroupSharedNotMe',
        data:{my_id:MyID},
        async: false,
    }).responseJSON;
    return sheetGroupSharedNotMe
}

function findSheetSharedToMe(MyID) {
    var sheetSharedToMe = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSheetSharedToMe',
        data:{my_id:MyID},
        async: false,
    }).responseJSON;
    return sheetSharedToMe
}

function readSheetTrial(data) {
    var test = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/readSheetTrial',
        data: data,
        async: false,
    }).responseJSON;
    return test;
}

//--------------------------- ExamRandomController ---------------------------
function findExamRandomByUID(UID,EMID) {
    var examRandom = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findExamRandomByUID',
        data:{user_id:UID,examing_id:EMID},
        async: false,
    }).responseJSON;
    return examRandom;
}

function addRandomExam(data) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/addRandomExam/'+data.examing_id+'/'+data.user_id+'/'+data.exam_id,
        async: false,
    });
}

function findExamRandomInViewExam(EXID,UID) {
    var examRandom = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findExamRandomInViewExam',
        data:{examing_id:EXID,user_id:UID},
        async: false,
    }).responseJSON;
    return examRandom;
}

//--------------------------- ResExamController ---------------------------

function findExamInScoreboard(EXID) {
    var examScoreboard = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findExamInScoreboard',
        data:{examing_id:EXID},
        async: false,
    }).responseJSON;
    return examScoreboard;
}

function dataInScoreboard(data) {
    var scoreBoard = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/dataInScoreboard',
        data:data,
        async: false,
    }).responseJSON;
    return scoreBoard;
}

function editScore(REID,score){
    var editScore = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/editScore',
        data:{
            resexam_id:REID,
            score : score
        },
        async: false,
    }).responseJSON;
    return editScore;
}

//--------------------------- PathExamController ---------------------------
function findPathExamByResExamID(REID) {
    var examScoreboard = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/findPathExamByResExamID',
        data:{resexam_id:REID},
        async: false,
    }).responseJSON;
    return examScoreboard;
}

function getCode(path) {
    var code = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/getCode',
        data:{path:path},
        async: false,
    }).responseJSON;
    return code;
}

function readFileResRun(path) {
    var resrun = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/readFileResRun',
        data: {path:path},
        async: false,
    }).responseJSON;
    return resrun;
}

//--------------------------- SheetingController ---------------------------

function findSheetingByNameAndGroup(name,GID) {
    var checked = false;
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSheetingByNameAndGroup',
        data:{sheeting_name:name,sheet_group_id:GID},
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

function createSheeting(data) {
    var createSheetingSuccess = false;
    var sheeting = $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/createSheeting',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    createSheetingSuccess = true;
                } else {
                    $('#open_worksheet_part').waitMe('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }

            }
        }
    }).responseJSON;
    if (createSheetingSuccess) {
        for(i=0;i<data.sheet.length;i++){
            createSheetSheeting(parseInt(data.sheet[i]),sheeting.id);
        }
        $('#open_worksheet_part').waitMe('hide');
        $('#success_modal').modal({backdrop: 'static'});
    }

}

function createSheetSheeting(sheetID,sheetingID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/createSheetSheeting',
        data:{sheet_id:sheetID,sheeting_id:sheetingID},
        async: false,
    });
}

function findSheetingByUserID(UID) {
    var sheeting = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSheetingByUserID',
        data:{user_id:UID},
        async: false,
    }).responseJSON;
    return sheeting;
}

function findSheetSheetingBySheetingID(STID) {
    var sheetSheeting =  $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSheetSheetingBySheetingID',
        data:{sheeting_id:STID},
        async: false,
    }).responseJSON;
    return sheetSheeting
}

function findSheetSheetingInSheetBoard(STID) {
    var sheetSheeting =  $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSheetSheetingInSheetBoard',
        data:{sheeting_id:STID},
        async: false,
    }).responseJSON;
    return sheetSheeting
}

function findSheetingByID(STID) {
    var sheeting =  $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSheetingByID',
        data:{id:STID},
        async: false,
    }).responseJSON;
    return sheeting
}

function updateSheeting(data) {
    var updateSheetingSuccess = false;
    $.ajax ({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/updateSheeting',
        data: data,
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    updateSheetingSuccess = true;
                } else {
                    $('#edit_sheeting_part').waitMe('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }

            }
        }
    });
    if (updateSheetingSuccess) {
        for(i=0;i<data.deleteSheetSheeting.length;i++){
            deleteSheetSheeting(data.deleteSheetSheeting[i],data.id) ;
        }
        for(i=0;i<data.sheet.length;i++){
            updateSheetSheeting(data.sheet[i],data.id);
        }
        $('#edit_sheeting_part').waitMe('hide');
        $('#success_modal').modal({backdrop: 'static'});
    }

}

function deleteSheetSheeting(sheetID,sheetingID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/deleteSheetSheeting',
        data:{sheet_id:sheetID,sheeting_id:sheetingID},
        async: false,
    });
}

function updateSheetSheeting(sheetID,sheetingID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/updateSheetSheeting',
        data:{sheet_id:sheetID,sheeting_id:sheetingID},
        async: false,
    });
}

function deleteSheeting(STID) {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/deleteSheeting',
        data:{id:STID},
        async: false,
        complete: function (xhr) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    $('#delete_part').waitMe('hide');
                    $('#success_modal').modal({backdrop: 'static'});
                }  else {
                    $('#delete_part').waitMe('hide');
                    $('#unsuccess_modal').modal({backdrop: 'static'});
                }
            }
        }
    });
}

function findSheetingByGroupID(GID) {
    var sheeting = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSheetingByGroupID',
        data:{group_id:GID},
        async: false
    }).responseJSON;
    return sheeting;
}

function findSTDSheetingByGroupID(GID) {
    var sheeting = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSTDSheetingByGroupID',
        data:{group_id:GID},
        async: false
    }).responseJSON;
    return sheeting;
}

function findSheetSheetingInViewSheet(STID,UID) {
    var sheetSheeting =  $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findSheetSheetingInViewSheet',
        data:{sheeting_id:STID,user_id:UID},
        async: false,
    }).responseJSON;
    return sheetSheeting
}

function findOldCodeInResSheet(STID,SID,UID) {
    var resSheet =  $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findOldCodeInResSheet',
        data:{sheeting_id:STID,sheet_id:SID,user_id:UID},
        async: false,
    }).responseJSON;
    return resSheet
}

function findQuizBySID(SID) {
    var quiz =  $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findQuizBySID',
        data:{sheet_id:SID},
        async: false,
    }).responseJSON;
    return quiz;
}

function findResQuizByRSID(RSID) {
    var resQuiz =  $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findResQuizByRSID',
        data:{ressheet_id:RSID},
        async: false,
    }).responseJSON;
    return resQuiz;
}

function dataInSheetBoard(GID,SID,STID) {
    var data =  $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/dataInSheetBoard',
        data:{
            group_id:GID,
            sheet_id:SID,
            sheeting_id:STID,
        },
        async: false
    }).responseJSON;
    return data;
}

function findResSheetByID(RSID) {
    var data =  $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url:url + '/findResSheetByID',
        data:{
            ressheet_id:RSID,
        },
        async: false
    }).responseJSON;
    return data;
}

function editTrialScore(RSID,score){
    var editTrialScore = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/editTrialScore',
        data:{
            ressheet_id:RSID,
            score : score
        },
        async: false,
    }).responseJSON;
    return editTrialScore;
}

function editQuizScore(RQID,score){
    var editQuizScore = $.ajax({
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },
        url: url + '/editQuizScore',
        data:{
            id:RQID,
            score : score
        },
        async: false,
    }).responseJSON;
    return editQuizScore;
}
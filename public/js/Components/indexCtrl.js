app.controller('indexCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.thisUser = $window.myuser;

    var current_time = new Date();
    keepHistory($window.myuser.id,"index",dtJsToDtDB(current_time));
    var user_online = findWebHistory();
    $scope.userOnline = user_online;
    
    var event = findMyEvent($scope.thisUser.id,$scope.thisUser.user_type);
    var ppEvent = prepareEventString(event);


    $(document).ready(function () {
        $('#side_index').attr('class','active');
        $('#index_div').show();

        $('#calendar').fullCalendar({
            header: { center: 'month,agendaWeek,agendaDay' },
            weekends: true, // will hide Saturdays and Sundays
            theme: 'standard',
            locale: 'th',
            contentHeight: 600,
            events: ppEvent,
            eventLimit: true, // for all non-agenda views
            views: {
                agenda: {
                    eventLimit: 6 // adjust to 6 only for agendaWeek/agendaDay
                }
            }
        });

        changeTitle();
        $('.fc-prev-button').on('click',function () {
            changeTitle();
        });

        $('.fc-next-button').on('click',function () {
            changeTitle();
        });

        $('.fc-month-button').on('click',function () {
            changeTitle();
        });

        $('.fc-agendaWeek-button').on('click',function () {
            changeTitle();
        });

        $('.fc-agendaDay-button').on('click',function () {
            changeTitle();
        });

        $('.fc-today-button').on('click',function () {
            changeTitle();
        });


//            $('#calendar').fullCalendar('next');
    });

    function changeTitle() {
        var title = $('.fc-left').children().html();
        var spilt = title.split(" ");
        spilt[spilt.length-1] = parseInt(spilt[spilt.length-1])+543;

        title = "";
        for(i = 0;i<spilt.length;i++){
            title +=  spilt[i]+" ";
        }
        $('.fc-left').children().html(title);

    }
    
    function prepareEventString(event) {
        var arrEvent = new Array();
        event.forEach(function(e) {
            var eventData = {
                title:  e.event_name,
                start:  prepareDatetimeString(e.start_date_time),
                end: prepareDatetimeString(e.end_date_time),
                allDay: false,
                color: e.type === 'E' ? '#5cb85c' : '#337ab7'
            }

            arrEvent.push(eventData);
        });
        return arrEvent;
    }

    function prepareDatetimeString(date) {
        dt = date.split(' ');
        d = dt[0]+'T'+dt[1];
        return d;
    }
}]);

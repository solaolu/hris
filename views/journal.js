function dailyTasks(){
    //get tasks
    $.ajax({
        type: "POST",
        url: "controllers/journal.php?action=tasks",
        contentType: "application/json",
        success: function(result){
                $("#template").load("views/templates/journal/calendar.html", function(){
                      
                      
                      
                      var A = result.code;
                      if( A!==null && A.length ){  //typeof A === "object") && (A !== null)
                          staff_tmpl = "<option value=\"${email}\">${fullname}</option>";
                          $list = result.code;
                          $.template("staffs", staff_tmpl);
                          $.tmpl("staffs",$list).appendTo($('#template select.stafflist'));
                      } else {
                          $(this).find("#assignees").remove();
                      }
                    
                      $template = $(this).html();
                      $("#view").html($template);
                      $("#template").empty();
                    
                      select2();
                      calendar(result.object);
                  });
        }
    });
    
}

function addTask(){
    var t = getJSONString("#taskForm");
    var formObject = t.formObject;
    //console.log(formObject);
    $.ajax({
        url:"controllers/journal.php?action=add",
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(formObject),
         success: function(result){
             if (result.isSuccessful){
                 if (result.code==null){
                     alert(result.message);
                 }
                 else {
                        var eventTitle = $('.new-event__title').val();
                        $('.calendar').fullCalendar('renderEvent', {
                            id: result.code, //GenRandom.Job()
                            title: eventTitle,
                            start: $('.new-event__start').val(),
                            end:  $('.new-event__end').val(),
                            allDay: true,
                            className: $('.event-tag input:checked').val()
                        }, true);

                        $('.new-event__form')[0].reset();
                        $('.new-event__title').closest('.form-group').removeClass('has-danger');
                        $('#new-event').modal('hide');
                 }
                 
             } else {
                 alert(result.message);
             }
         },
        error: function () {
            alert('an error occured');
        },
        complete: function () {

        }
    });
}

function updateTask(){
    var t = getJSONString("#taskEditForm");
    var formObject = t.formObject;
    //console.log(formObject);
    $.ajax({
        url:"controllers/journal.php?action=update",
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(formObject),
         success: function(result){
             if (result.isSuccessful){
                 alert(result.message);
                 
             } else {
                 alert(result.message);
             }
         },
        error: function () {
            alert('an error occured');
        },
        complete: function () {

        }
    });
}

function deleteTask(taskID){
    $.ajax({
        url:"controllers/journal.php?action=delete&id="+taskID,
        type: "POST",
        contentType: "application/json",
         success: function(result){
             if (result.isSuccessful){
                 //alert(result.message);
                 
                                swal({
                                    title: 'Deleted!',
                                    text: result.message,
                                    type: 'success',
                                    buttonsStyling: false,
                                    cancelButtonClass: 'btn btn-light',
                                    background: 'rgba(0,0,0,0.096)'
                                });
             } else {
                 alert(result.message);
             }
         },
        error: function () {
            alert('an error occured');
        },
        complete: function () {

        }
    });
}

function weeklyReport(){
        $.ajax({
        url:"controllers/journal.php?action=week",
        type: "POST",
        contentType: "application/json",
         success: function(result){
             if (result.isSuccessful){
                 $("#template").load("views/templates/journal/weekly-report.html", function(){
                     $template = $(this).html();
                     
                     
                     $.template("template", $template);
                     $tmp = $.tmpl("template", result);
                     
                     $("#view").html($tmp);
                     $("#template").empty();
                     
                     $("#view").find(".wysiwyg-editor").trumbowyg({autogrow:!0})
                 });
             } else {
                 alert(result.message);
             }
         },
        error: function () {
            alert('an error occured');
        },
        complete: function () {

        }
    });
}

function saveWeekReport(){
    var t = getJSONString("#weekReportForm");
    var formObject = t.formObject;
    console.log(formObject);
    $.ajax({
        url:"controllers/journal.php?action=report",
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(formObject),
         success: function(result){
             if (result.isSuccessful){
                 alert(result.message);
                 
             } else {
                 alert(result.message);
             }
         },
        error: function () {
            alert('an error occured');
        },
        complete: function () {

        }
    });
}

function getReport(user, name){
            $.ajax({
        url:"controllers/journal.php?action=getreport&f="+user,
        type: "POST",
        contentType: "application/json",
        success: function(result){
             if (result.isSuccessful){
                 report = result.object;
                 $('#week__tag').html(report[0].week);
                 $('#user__tag').html(name);
                 $('#report-window').find('.modal-body').html(report[0].report);
                 $('#report-window').modal('show');
             } else {
                 alert(result.message);
             }
         },
        error: function () {
            alert('an error occured');
        },
        complete: function () {

        }
    });
}

function lineTasks(){
    $.ajax({
        url:"controllers/journal.php?action=line",
        type: "POST",
        contentType: "application/json",
         success: function(result){
             if (result.isSuccessful){
                 //populate dashboard
                 $("#template").load("views/templates/journal/line-dashboard.html", function(){
                     $userCard = $(this).find('#user-card').html();
                     $.template("card", $userCard);
                     $.tmpl("card", result.object).appendTo($(this).find("#user-card").empty());
                     
                     $template = $(this).html();
                     
                     $.template("template", $template);
                     $tmp = $.tmpl("template", result);
                     
                     $("#view").html($tmp);
                     $("#template").empty();
                 });
                 
             } else {
                 alert(result.message);
             }
         },
        error: function () {
            alert('an error occured');
        },
        complete: function () {

        }
    });
}

function calendar(tasks){
            'use strict';
            $(document).ready(function() {
                var date = new Date();
                var m = date.getMonth();
                var y = date.getFullYear();

                $('.calendar').fullCalendar({
                    header: {
                        right: '',
                        center: '',
                        left: ''
                    },
                    buttonIcons: {
                        prev: 'calendar__prev',
                        next: 'calendar__next'
                    },
                    theme: false,
                    selectable: true,
                    selectHelper: true,
                    editable: true,
                    events: tasks,

                    dayClick: function(date) {
                        var isoDate = moment(date).toISOString();
                        $('#new-event').modal('show');
                        $('.new-event__title').val('');
                        $('.new-event__start').val(isoDate);
                        $('.new-event__end').val(isoDate);
                    },

                    viewRender: function (view) {
                        var calendarDate = $('.calendar').fullCalendar('getDate');
                        var calendarMonth = calendarDate.month();

                        //Set data attribute for header. This is used to switch header images using css
                        $('.calendar .fc-toolbar').attr('data-calendar-month', calendarMonth);

                        //Set title in page header
                        $('.content__title--calendar > h1').html(view.title);
                        
                        //block future dates
                        /*if (view.start > maxDate){
                            $('.calendar').fullCalendar('gotoDate', maxDate);
                        }*/
                    },

                    eventClick: function (event, element) {
                        $('#edit-event').modal('show');
                        $('.edit-event__id').val(event.id);
                        $('.edit-event__title').val(event.title);
                        $('.edit-event__description').val(event.description);
                    },
                    defaultView: 'basicDay',
                    businessHours: true,
                    eventRender: function(event, element) {
                        //differentiate LM assigned tasks
                        if(event.owner == event.addedBy) {
                            element.css('background-color', '#000');
                        }
                    }
                });


                //Add new Event
                $('body').on('click', '.new-event__add', function(){
                    var eventTitle = $('.new-event__title').val();

                    // Generate ID
                    var GenRandom =  {
                        Stored: [],
                        Job: function(){
                            var newId = Date.now().toString().substr(6); // or use any method that you want to achieve this string

                            if( !this.Check(newId) ){
                                this.Stored.push(newId);
                                return newId;
                            }
                            return this.Job();
                        },
                        Check: function(id){
                            for( var i = 0; i < this.Stored.length; i++ ){
                                if( this.Stored[i] == id ) return true;
                            }
                            return false;
                        }
                    };

                    if (eventTitle != '') {
                        addTask(); 
                    }
                    else {
                        $('.new-event__title').closest('.form-group').addClass('has-danger');
                        $('.new-event__title').focus();
                    }
                });


                //Update/Delete an Event
                $('body').on('click', '[data-calendar]', function(){
                    var calendarAction = $(this).data('calendar');
                    var currentId = $('.edit-event__id').val();
                    var currentTitle = $('.edit-event__title').val();
                    var currentDesc = $('.edit-event__description').val();
                    var currentEvent = $('.calendar').fullCalendar('clientEvents', currentId);

                    //Update
                    if(calendarAction === 'update') {
                        if (currentTitle != '') {
                            currentEvent[0].title = currentTitle;
                            currentEvent[0].description = currentDesc;

                            $('.calendar').fullCalendar('updateEvent', currentEvent[0]);
                            updateTask();
                            
                            $('#edit-event').modal('hide');
                        }
                        else {
                            $('.edit-event__title').closest('.form-group').addClass('has-error');
                            $('.edit-event__title').focus();
                        }
                    }

                    //Delete
                    if(calendarAction === 'delete') {
                        $('#edit-event').modal('hide');
                        setTimeout(function () {
                            swal({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                type: 'warning',
                                showCancelButton: true,
                                buttonsStyling: false,
                                confirmButtonClass: 'btn btn-danger',
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonClass: 'btn btn-light',
                                background: 'rgba(0,0,0,0.096)'
                            }).then(function() {
                                $('.calendar').fullCalendar('removeEvents', currentId);
                                deleteTask(currentId);
                            })
                        }, 200);
                    }
                });


                //Calendar views switch
                $('body').on('click', '[data-calendar-view]', function(e){
                    e.preventDefault();

                    $('[data-calendar-view]').removeClass('actions__item--active');
                    $(this).addClass('actions__item--active');
                    var calendarView = $(this).attr('data-calendar-view');
                    $('.calendar').fullCalendar('changeView', calendarView);
                });


                //Calendar Next
                $('body').on('click', '.actions__calender-next', function (e) {
                    e.preventDefault();
                    $('.calendar').fullCalendar('next');
                });


                //Calendar Prev
                $('body').on('click', '.actions__calender-prev', function (e) {
                    e.preventDefault();
                    $('.calendar').fullCalendar('prev');
                });
            });
}
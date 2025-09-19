function leaveCalendar(){
    //get leave days
       $.ajax({
        type: "POST",
        url: "controllers/leave.php?action=getdays",
        contentType: "application/json",
        success: function(result){
            $('#view').load("views/templates/leave/calendar.php", function(){
                $.each(result.code, function(index, val){
                    $(val).addClass("bg-primary");
                    console.log(val);
                });
            });
        }
    });
    
}

function leaveRequest(){
    $.ajax({
        type: "POST",
        url: "controllers/leave.php?action=nextdays",
        contentType: "application/json",
        success: function(result){ 
            if (result.isSuccessful){  
             $('#template').load("views/templates/leave/request.html", function(){
                      $template = $(this).html();
                      $.template("template", $template);
                      $tmp = $.tmpl("template", result);
                      $('#view').html($tmp);
                      $(this).empty();
                      datepicker();
             });
                      }
            else {
                $('#view').html(result.message);
                }
            }
        });
}

function submitLeaveRequest(){
    var data = getJSONString("#leaveRequestForm");
    var formObject = data.formObject;
    //check if it has files and do uploads then do normal post based on upload result, else just do normal post
    console.log($('#leaveRequestForm').find('input[name="handoverNote"]').val());
    if (data.files && $('#leaveRequestForm').find('input[name="handoverNote"]').val()!='') {
        //do upload
        data = data.formData;
        $.ajax({
                type: "POST",
                url: "utilities/upload.php?dir=handovers",
                data: data,
                contentType: false,
                processData: false,
                traditional: true,
                success: function (result) {
                    formObject["handoverNote"] = result;
                    postLeaveRequest(formObject);
                }}
        );
    } 
    else {   
        alert("Unable to submit your request, you have not included your handover note. Please attach one and retry.");
        //postLeaveRequest(formObject);
    }
}

function postLeaveRequest(obj){
    $.ajax({
    url:"controllers/leave.php?action=submit",
    type: "POST",
    contentType: "application/json",
     data: JSON.stringify(obj),
     success: function(result){
         if (result.isSuccessful){
             $('#view').html(result.message);
          /*$("#view").load("views/templates/leave/__.html", function(){
              
          });*/ 
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

function lineLeaveRequests(){
    $.ajax({
        url: "controllers/leave.php?action=list",
        contentType: "application/json",
        type: "POST",
        success: function(result){
            if (result.isSuccessful){
                $("#template").load("views/templates/leave/list.htm", function(){
                      //console.log(result.object);
                      $row_tmpl = $(this).find('tbody').html();
                      $.template("rows", $row_tmpl);
                      $.tmpl("rows", result.object).appendTo($(this).find('tbody').empty());
                      $template = $(this).html();
                      $("#view").html($template);
                      $('.data-table').DataTable();
                      $("#template").empty();
                  }); 
            } else {
                $("#view").html(result.message);
                //alert(result.message);
            }
        }
    });
}

function processLeave(rID, response){
    var obj = {
        app: "LM",
        status: response,
        ID: rID
    }
    $.ajax({
        url:"controllers/leave.php?action=process",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(obj),
        success: function(result){
             if (result.isSuccessful){
                 //$('#view').html(result.message);
                 alert(result.message);
                 $('#view').find('#row-'+rID).hide();
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
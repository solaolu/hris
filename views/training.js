function trainingRequests(){
       $.ajax({
        url: "controllers/training.php?action=requests",
        contentType: "application/json",
        type: "POST",
        success: function(result){
            if (result.isSuccessful){
                if (result.code!=0){
                load(result);
                } else {
                    $("#view").html("<p><strong>"+result.message+"</strong></p>");
                }
            } else {
                alert(result.message);
            }
        }
    });
}

function newTrainingRequest(){
  $('#card-header').text("Training & Development");
  $("#template").load("views/templates/training/new.html", function(){
      
    $template = $('#template').html();

    $("#view").html($template);
    //$('select').select2({dropdownAutoWidth:!0,width:"100%"});
      datepicker();
    $("#template").empty();
      
  }); 
}

function postTrainingRequest(){
    var tr = getJSONString("#trainingRequestForm");
    var formObject = tr.formObject;
    //console.log(formObject);
    $.ajax({
        url:"controllers/training.php?action=add",
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(formObject),
         success: function(result){
             if (result.isSuccessful){
              alert(result.message);
              trainingRequests();
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

function openTrainingRequest(id){
        $.ajax({
        url: "controllers/training.php?action=open",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({id:id}),
        success:function(result){
          if (result.isSuccessful){
              $("#template").load("views/templates/training/open.html", function(){
                  if (result.code!=1) $(this).find('#LMAction').remove();
                  
                  $template = $(this).html();
                  $.template("template", $template);
                  $tmp = $.tmpl("template", result.object);
                  $("#view").html($tmp);
                  
                  $("#template").empty();
              }); 
         } else {
             alert(result.message);
         }
        }
    });
}

function processTrainingRequest(status){
    
    var trainingApproval = getJSONString("#LMAction").formObject;
    trainingApproval["status"]=status?"APPROVED":"DISAPPROVED";
    //memoApproval["approver"]="";
    
     $.ajax({
        url: "controllers/training.php?action=process",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(trainingApproval),
        success:function(result){
          if (result.isSuccessful){
              alert(result.message);
              load(result);
         } else {
             alert(result.message);
         }
        }
    });
}

function incomingRequests(){
           $.ajax({
        url: "controllers/training.php?action=lineRequests",
        contentType: "application/json",
        type: "POST",
        success: function(result){
            if (result.isSuccessful){
                if (result.code!=0){
                    load(result); 
                } else {
                    $("#view").html("<p><strong>"+result.message+"</strong></p>");
                }
            } else {
                alert(result.message);
            }
        }
    });
}

function load(result){
   $("#template").load("views/templates/training/incoming.html", function(){
                      
                      $row_tmpl = $(this).find('tbody').html();
                      $.template("rows", $row_tmpl);
                      $.tmpl("rows", result.object).appendTo($(this).find('tbody').empty());
                      $template = $(this).html();
                      $("#view").html($template);
                      $('.data-table').DataTable();
                      $("#template").empty();
                    
    }); 
}
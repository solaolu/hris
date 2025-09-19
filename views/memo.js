function process(status){
    
    var memoApproval = getJSONString("#MemoAction").formObject;
    memoApproval["status"]=status?"APPROVED":"DISAPPROVED";
    memoApproval["approver"]="";
    
     $.ajax({
        url: "controllers/memo.php?action=process",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(memoApproval),
        success:function(result){
          if (result.isSuccessful){
              alert(result.message);
              $("#template").load("views/templates/memo/inbox.html", function(){
                      
                      $row_tmpl = $(this).find('tbody').html();
                      $.template("rows", $row_tmpl);
                      $.tmpl("rows", result.object).appendTo($(this).find('tbody').empty());
                      $template = $(this).html();
                      $("#view").html($template);
                      $('.data-table').DataTable();
                      $("#template").empty();
                  }); 
         } else {
             processFailedRequests(result);
         }
        }
    });
}

function create(){
  $('#card-header').text(":: New Memo ::");
  $("#template").load("views/templates/memo/new.html", function(){
      staff_tmpl = "<option value=\"${email}\">${staffname}</option>";
      
      $.ajax({
        url:"controllers/staff.php?action=getAll",
        type: "POST",
        contentType: "application/json",
        success: function(result){
             if (result.isSuccessful){
                $list = result.object;
                $.template("staffs", staff_tmpl);
                $.tmpl("staffs",$list).appendTo($('#template select.stafflist'));

                $template = $('#template').html();

                $("#view").html($template);
                $('.select2').select2({dropdownAutoWidth:!0,width:"100%"});
                $("#template").empty();
             } else {
                 processFailedRequests(result);
             }
         },
        error: function () {
            alert('an error occured');
        },
        complete: function () {
            return $list;
        }
      });
      
  }); 
}

function send(){
    var memo = getJSONString("#MemoForm");
    var formObject = memo.formObject;
    //check if it has files and do uploads then do normal post based on upload result, else just do normal post
    if (memo.files) {
        //do upload
        data = memo.formData;
        $.ajax({
                type: "POST",
                url: "utilities/upload.php?dir=memos",
                data: data,
                contentType: false,
                processData: false,
                traditional: true,
                success: function (result) {
                    formObject["attachments"] = result;
                    console.log(formObject);
                    postMemo(formObject);
                }}
        );
    } 
    else {   
        postMemo(formObject);
    }
}

function postMemo(memo){
$.ajax({
    url:"controllers/memo.php?action=send",
    type: "POST",
    contentType: "application/json",
     data: JSON.stringify(memo),
     success: function(result){
         if (result.isSuccessful){
          $("#template").load("views/templates/memo/send.html", function(){
              $template = $(this).html();
              $("#view").html(result.message);
              $("#template").empty();
          }); 
         } else {
             processFailedRequests(result);
         }
     },
    error: function () {
        alert('an error occured');
    },
    complete: function () {
        
    }
});
}

function inbox(){
    $.ajax({
        url: "controllers/memo.php?action=inbox",
        contentType: "application/json",
        type: "POST",
        success: function(result){
            if (result.isSuccessful){
                $("#template").load("views/templates/memo/inbox.html", function(){
                      
                      $row_tmpl = $(this).find('tbody').html();
                      $.template("rows", $row_tmpl);
                      $.tmpl("rows", result.object).appendTo($(this).find('tbody').empty());
                      $template = $(this).html();
                      $("#view").html($template);
                      $('.data-table').DataTable();
                      $("#template").empty();
                  }); 
            } else {
                processFailedRequests(result);
            }
        }
    });
}

function outbox(){
    $.ajax({
        url: "controllers/memo.php?action=outbox",
        contentType: "application/json",
        type: "POST",
        success: function(result){
            if (result.isSuccessful){
                $("#template").load("views/templates/memo/outbox.html", function(){
                      $row_tmpl = $(this).find('tbody').html();
                      $.template("rows", $row_tmpl);
                      $.tmpl("rows", result.object).appendTo($(this).find('tbody').empty());
                      $template = $(this).html();
                      $("#view").html($template);
                      $('.data-table').DataTable();
                      $("#template").empty();
                  }); 
            } else {
                alert(result.message);
            }
        }
    });
}

function openMemo(id){
    $.ajax({
        url: "controllers/memo.php?action=open",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({id:id}),
        success:function(result){
          if (result.isSuccessful){
              $("#template").load("views/templates/memo/open.html", function(){
                  if (result.code!=1) $(this).find('#MemoAction').remove();
                  
                  $row = $(this).find('#approvalstmpl').html();
                  $.template("approws", $row);
                  $obj = result.object[0];
                  //console.log($obj.status);
                  $.tmpl("approws", $obj.status).appendTo($("#template").find('#approvalstmpl').empty());
                  
                  $template = $(this).html();
                  $.template("template", $template);
                  $tmp = $.tmpl("template", result.object);
                  $("#view").html($tmp);//.append((result.code==1) ? "<p align=center><a class='btn btn-success' href=# onclick='process(1, "+id+")'>Approve</a>&nbsp;<a class='btn btn-danger' href=# onclick='process(2, "+id+")'>Disapprove</a></p>":"");
                  
                  $("#template").empty();
              }); 
         } else {
             alert(result.message);
         }
        }
    });
}
$(document).ready(function() {
     $.get("controllers/dashboard.php?action=load", function(result){
        if (result.isSuccessful){
            
            obj = result.object;
            
            tasks=obj.task;
            
            $userCard = $('#dTasks').html();
                     $.template("card", $userCard);
                     $.tmpl("card", tasks).appendTo($("#dTasks").empty());
                     
                     /*$template = $(this).html();
                     
                     $.template("template", $template);
                     $tmp = $.tmpl("template", tasks);
                     
                     $("#view").html($tmp);
            */
            
            leave=obj.leave;
                $leaveCard = $('#leaveCounter').html();
                $.template("card", $leaveCard);
                $.tmpl("card", leave.object).appendTo($("#leaveCounter").empty());
            
            request=obj.request;
                $notice = $("#notificationsCard").html();
                $.template("card", $notice);
                $.tmpl("card", request).appendTo($("#notificationsCard").empty());
        }
         else {
             processFailedRequests(result);
         }
    });
});
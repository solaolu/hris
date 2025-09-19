function payslip(date=null, view_=null){
if (date==null) date=0;
console.log(view_);
    $.ajax({
        url: "controllers/payroll.php?action=payslip&paydate="+date,
        contentType: "application/json",
        type: "POST",
        success: function(result){
            if (result.isSuccessful){
                $("#template").load("views/templates/payroll/payslip.html", function(){
                      
                    
                      $inc_tmpl = $(this).find('#income tbody').html();
                      $ded_tmpl = $(this).find('#deductions tbody').html();
                      
                      $.template("incomes", $inc_tmpl);
                      $.tmpl("incomes", result.object.incomes).appendTo($(this).find('#income tbody').empty());
                    
                      $.template("deductions", $ded_tmpl);
                      $.tmpl("deductions", result.object.deductions).appendTo($(this).find('#deductions tbody').empty());
                      
                      $template = $("#template").html();
                      //console.log($template);
                      $.template("template", $template);
                      $tmp = $.tmpl("template", result.object);
                      
                        if (view_) {
                            $("#view").html($tmp); }
                        else {
                            $("#payslipBox").html($tmp);
                        }
                      $("#template").empty();
                  }); 
            } else {
                alert(result.message);
            }
        }
    });

}

function archives(){
    $.ajax({
        url: "controllers/payroll.php?action=archives",
        contentType: "application/json",
        type: "POST",
        success: function(result){
            if (result.isSuccessful){
                
                $('#template').load("views/templates/payroll/payslip-loader.html", function(){
                    $option = "<option value='${payslipDate}'>${date}</option>";
                    $.tmpl($option, result.object).appendTo($(this).find('#archivelist'));
                    $('#view').html($(this).html());
                    $(this).empty();
                    select2();
                });
                
            } else {
                alert(result.message);
            }
        }
    });
}

function makeSlipRequest()
{
    $('#view').load('views/templates/payroll/slipRequest.html', function(){
        datepicker();
    });
    
}

function requestPayslip(){
    var formData = getJSONString("#slipRequestForm");
    var request = formData.formObject;
    
    $.ajax({
        url: "controllers/payroll.php?action=request",
        contentType: "application/json",
        data: JSON.stringify(request),
        type: "POST",
        success: function(result) {
            if (result.isSuccessful){
                
               $('#view').html(result.message);
                
            } else {
                alert(result.message);
            }
        }
    });
}
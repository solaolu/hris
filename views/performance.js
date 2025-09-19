var PerformanceTracker = {
    user: "",
    subordinate: "",
    myPerformance: function(mth, year){
        //load user's performance
        $.ajax({
            url:"controllers/performance.php?action=myperformance&m="+mth+"&y="+year,
            type: "POST",
            contentType: "application/json",
             success: function(result){
                if (result.isSuccessful){
                        
                        rows_template = "<tr id='card${ID}'><td>${initiative}</td><td>${task}</td><td class='weight' align=right data-weight='${weight}'>${weight}</td><td>${rating}</td><td class='score' align='right'>${rating * weight}</td></tr>";
                        //div="#performance--box";
                        page = "line-performance.html";
                        mgr=true;
                        
                        $('#template').load("views/templates/performance/"+page, function(){
                                            
                            //sections = ;
                            //section_template = "<tr id=section${id}><td class='bg-info' colspan=6 ><strong>${section}</strong></td></tr>";
                            
                            
                            //$.tmpl(section_template, result.object).appendTo($('#template').find('.kpi-tbody'));
                    
                            //for (i=0;i<result.object.length;i++){
                                $.tmpl(rows_template, result.object).appendTo($('#template').find('.kpi-tbody'));//.find('#section'+i));
                                //console.log(result.object[i]);
                            //}
                    
                            template=$(this).html();
                            $html = $.tmpl(template, result);
                            //$(div).html($html);

                            
                            $(this).empty();
                            $('#view').html($html);
                            $('#view').find('#performanceResponse').remove();
                            //select2();
                            
                        });
                } else {
                    $('#view').html(result.message);
                }
             },
            error: function () {
                alert('an error occured');
            },
            complete: function () {
            }
         });
    },

    myComment: function(){
        //comment on personal performance evaluation
    },

    mySubordinates: function(){
        //load line subordinates
        $.get("controllers/staff.php?action=subordinates", function(result){
            if (result.isSuccessful){
                $('#template').load("views/templates/performance/line-performance-loader.html", function(){
                    $option = "<option value='${email}'>${fullname}</option>";
                    $.tmpl($option, result.object).appendTo($(this).find('#stafflist'));
                    $('#view').html($(this).html());
                    $(this).empty();
                    select2();
                });
            }
          }); 
    },

    subordinatePerformance: function(email, mth, year){
        //load performance scorecard for subordiante
        $.ajax({
            url:"controllers/performance.php?action=tasks&e="+email+"&m="+mth+"&y="+year,
            type: "POST",
            contentType: "application/json",
             success: function(result){
                if (result.isSuccessful){
                        
                        rows_template = "<tr id='card${ID}'><td>${initiative}</td><td>${task}</td><!--<td>${rating}</td>--><td class='weight' align=right data-weight='${weight}'>${weight}</td><td><select name=kpiRating${ID} class='rating select2' data-minimum-results-for-search='Infinity' onchange='getScore(${ID});'><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option></select></td><td class='score' align='right'></td></tr>";
                        div="#performance--box";
                        page = "line-performance.html";
                        mgr=true;
                        
                        $('#template').load("views/templates/performance/"+page, function(){
                                            
                            //sections = ;
                            //section_template = "<tr id=section${id}><td class='bg-info' colspan=6 ><strong>${section}</strong></td></tr>";
                            
                            
                            //$.tmpl(section_template, result.object).appendTo($('#template').find('.kpi-tbody'));
                    
                            //for (i=0;i<result.object.length;i++){
                                $.tmpl(rows_template, result.object).appendTo($('#template').find('.kpi-tbody'));//.find('#section'+i));
                                //console.log(result.object[i]);
                            //}
                    
                            template=$(this).html();
                            $html = $.tmpl(template, result);
                            $(div).html($html);
                            $(this).empty();
                            select2();
                            
                        });
                } else {
                    //alert(result.message);
                    $('#performance--box').html(result.message);
                }
             },
            error: function () {
                alert('an error occured');
            },
            complete: function () {
            }
         });

        
    },

    evaluate: function($obj){
        //save evaluation of subordinate's performance
        var notify='';
        $.ajax({
            url:"controllers/performance.php?action=evaluate"+notify,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify($obj),
            success: function(result){
                if (result.isSuccessful){
                    $('#view').html(result.message);
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


};

var PT = PerformanceTracker;

function getMyPerformance(){
    var d = new Date();
    PT.myPerformance(d.getMonth(), d.getFullYear());
}

function getLine(){
    PT.mySubordinates();
}

function getSubordinatePerformance(email){
    //get date based on current year and month
    var d = new Date();
    PT.subordinatePerformance(email, d.getMonth()+1, d.getFullYear());
}

function evaluatePerformance(){
    $frm=getJSONString('#LMAssessmentForm');
    var $obj = $frm.formObject;
    PT.evaluate($obj);
}
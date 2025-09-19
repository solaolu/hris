function start(){
    $('#view').load("views/templates/appraisal/start.html");
}

function step1(){
    $.get("controllers/appraisals.php?action=start", function(result){
        console.log(result);
        if (result.isSuccessful){
            if (result.code!=null){
                    if (Number(result.locked)>=2) result.mode=4;
                    loadStep2(result);
            }
            else{
                var serialNumber = 1;
                // Modify the object to add serialNumber to each item
                $.each(result.object, function(index, item) {
                    item.serialNumber = serialNumber++;  // Add serial number to each item
                });
                console.log("serial count: "+serialNumber);
                $('#template').load("views/templates/appraisal/step1.html", function(){
                    template=$(this).html();
                    $html = $.tmpl(template, result);
                    $('#view').html($html);
                    $(this).empty();

                    datepicker();
                });
            }
        }
    });
    
}

function step2(){
    $frm=getJSONString('#appraisalStartForm');
    var formObject = $frm.formObject;
    $.ajax({
        url:"controllers/appraisals.php?action=save1",
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(formObject),
         success: function(result){
            if (result.isSuccessful){
                    alert("Appraisal started successfully!"); //comment only
                    loadStep2(result);
            } else {
                alert(result.message);
            }
         },
        error: function () {
            alert('an error occured');
        },
        complete: function () {
            //console.log(result);
        }
     });
}

function loadStep2(result){
    var page="step2.html";
    console.log(result);
    var div="#view";
    var mgr=false;
    var rows_template="<tr id='card${ID}'><td>${initiative}</td><!--<td>${rating}</td>--><td class='weight' data-weight='${weight}'>${weight}</td><td align=right class='lm_rating_col'>${(mgr_score/weight).toFixed(0)}</td><td><select name=kpiRating${ID} class='rating select2'  data-minimum-results-for-search='Infinity' onchange='getScore(${ID});'><option value='${(score/weight).toFixed(0)}'>${(score/weight).toFixed(0)}</option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option></select></td><td class='score' align='right'>${score}</td><td>${max}</td></tr>";
    console.log(result.mode);
        switch (result.mode){
            case 1: //sent to manager
                rows_template = "<tr id='card${ID}'><td>${initiative}</td><!--<td>${rating}</td>--><td class='weight' data-weight='${weight}'>${weight}</td><td>${(score/weight).toFixed(0)}</td><td class='score' align='right'>${score}</td><td>${max}</td></tr>";
                break;
            case 2: //contract view only
                rows_template = "<tr ><td>${initiative}</td><!--<td>${rating}</td>--><td class='weight' data-weight='${weight}'>${weight}</td><td>${max}</td></tr>";
                page = "contract.html";
                break;
            case 3: // load mgr view
                rows_template = "<tr id='card${ID}'><td>${initiative}</td><!--<td>${rating}</td>--><td class='weight' data-weight='${weight}'>${weight}</td><td>${(score/weight).toFixed(0)}</td><td><select name=kpiRating${ID} class='rating select2'  data-minimum-results-for-search='Infinity' onchange='getScore(${ID});'><option value=''>0</option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option></select></td><td class='score' align='right'></td><td>${max}</td></tr>";
                div="#appraisal--box";
                page = "line-appraisal.html";
                mgr=true;
                break;
            case 4: //respond to review only
            case 5:
                
                rows_template="<tr id='card${ID}'><td>${initiative}</td><!--<td>${rating}</td>--><td class='weight' data-weight='${weight}'>${weight}</td><td align=right class='lm_rating_col'>${(mgr_score/weight).toFixed(0)}</td><td align=right>${(score/weight).toFixed(0)}</td><td class='score' align='right'>${score}</td><td>${max}</td></tr>";
                break;
        }
    
    
    
    $('#template').load("views/templates/appraisal/"+page, function(){
                        
        //sections = ;
        section_template = "<tr id=section${id}><td class='bg-info' colspan=6 ><strong>${section}</strong></td></tr>";
        
        
        
        switch (Number(result.locked)) {
            case 0:$('.lm_rating_col').remove(); break; //start
            case 1:$('.lm_rating_col').remove(); $('.save_button').remove();break; //view only
            case 2:$('.save_button').remove(); break; //review and respond
            case 3:$('.my_response').remove();break;$('.save_button').remove();//view only after response
            //case 2:
        }
        
        $.tmpl(section_template, result.object).appendTo($('#template').find('.kpi-tbody'));

        for (i=0;i<result.object.length;i++){
            $.tmpl(rows_template, result.object[i].detail).appendTo($('#template').find('#section'+i));
            //console.log(result.object[i]);
        }

        template=$(this).html();
        $html = $.tmpl(template, result);
        $(div).html($html);
        $(this).empty();
        select2();
        
        if (result.mode!=3) reCalculate();
    });
}

function saveKPI($send){
    $frm=getJSONString('#kpiForm');
    var formObject = $frm.formObject;
    var notify='';
    if ($send) notify="&notify=1";
    $.ajax({
        url:"controllers/appraisals.php?action=savekpi"+notify,
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(formObject),
         success: function(result){
            if (result.isSuccessful){
                $('#view').html(result.message);
                //clear KPI area
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

function save_mgr_rating(){
    $frm=getJSONString('#LMAssessmentForm');
    var formObject = $frm.formObject;
    var notify='';
    $.ajax({
        url:"controllers/appraisals.php?action=approve"+notify,
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(formObject),
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

function respond(){
    $frm=getJSONString('#kpiForm');
    var formObject = $frm.formObject;
    $.ajax({
        url:"controllers/appraisals.php?action=respond",
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(formObject),
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

function getScore(id){
    kpiRow = $('#card'+id);
    score=kpiRow.find('.weight').data('weight') * kpiRow.find('.rating').val();
    
    kpiRow.find('.score').text(score.toFixed(1));
    reCalculate();
}

function reCalculate() {

        var scoreSum=0;
        $('.score').each(function(){
            scoreSum+=Number($(this).text());
        });
        $('#score_summary').text(scoreSum.toFixed(1));

    $('input[name=score_summary]').val(scoreSum.toFixed(1));
}

function contract(){
      $.get("controllers/appraisals.php?action=contract", function(result){
        if (result.isSuccessful){
            result.mode=2;
                loadStep2(result);
            
        }
      });
}

function getlines(){
      $.get("controllers/appraisals.php?action=readylines", function(result){
        if (result.isSuccessful){
            $('#template').load("views/templates/appraisal/line-appraisal-loader.html", function(){
                $option = "<option value='${email}'>${fullname}</option>";
                $.tmpl($option, result.object).appendTo($(this).find('#stafflist'));
                $('#view').html($(this).html());
                $(this).empty();
                select2();
            });
        }
      });    
}

function appraisal_reset(){
    $.get('controllers/appraisals.php?action=unlock&c='+$('#kpiID').val(),function(result){
        if (result.isSuccessful){
            $('#appraisal--box').html("<strong>"+result.message+"</strong>");
        }
    });
}

function load_line_appraisal(email){
    $.get("controllers/appraisals.php?action=loadappraisal&email="+email, function(result){
        if (result.isSuccessful){
            result.mode=3;
            loadStep2(result);
        }
    });
}

function clean(obj){
    var key;
    for (key in obj) {
        obj[key] = escape(obj[key]);
    }
    return obj;
}
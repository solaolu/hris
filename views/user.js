var dependents=[];
function readHandbook(){
    $.get("controllers/user.php?action=readhandbook");
    $('#handbookModal').modal('hide');
}


function changePassword()
{    
    var formData = getJSONString("#passwordChangeForm");
    var request = formData.formObject;
    
    if (request.newpassword==request.cnewpassword){
        $.ajax({
            url:"../controllers/user.php?action=changepassword",
            type: "POST",
            contentType: "application/json",
             data: JSON.stringify(request),
             success: function(result){
                $('.login__block__body').html(result.message);
                 var x = setTimeout(function() { location.href='../app.php'; }, 2000); 
             },
            error: function () {
                alert('an error occured');
            },
            complete: function () {
            }
        }

        );
    } else {
        $('input[name="cnewpassword"] + strong').remove();
        $('input[name="cnewpassword"]').after("<strong>passwords do not match</strong>");
    }
}

function viewProfile(){
    $.get("controllers/staff.php?action=profile", function(result){
        if (result.isSuccessful){
            //show profile
            $('#template').load("views/templates/profile/view.php", function(){
                html = $(this).html();
                $(this).empty();
                tmp = $.tmpl(html, result.object);
                $('#view').html(tmp);
                
                //set dependents to variable
                $profile=result.object;
                dependents = $profile.dependents;
            });
        } 
        else { //load form
            $('#template').load("views/templates/profile/form.php", function(){
                html = $(this).html();$(this).empty();
                tmp = $.tmpl(html, result);
                $('#view').html(tmp);
                select2(); datepicker(); datetimepicker();
            });
        }
    });
}

function editProfile(){
    $('#view').empty();
    $('#view').load("views/templates/profile/edit.php", function(){
        select2(); datepicker(); datetimepicker();
    });   
}

function editDependent(id){
    var result = $.grep(dependents, function(e){ 
     return e.ID == id; 
    });
    
    //load template
    $.get("views/templates/profile/dependentForm.php", function(data, status, xhr)
          {
                if (status=="success"){
                    html = data;
                    tmp = $.tmpl(html, result);
                    $('#dependentView').html(tmp);
                    select2(); datepicker(); datetimepicker();
                    //open modal
                    $('#dependentModal').modal('show');
                }
            }
         );
    
}

function addNewDependent(){
    $('#dependentView').load("views/templates/profile/dependentForm.php?form=new", function(){
        select2(); datepicker(); datetimepicker();
        $('#dependentModal').modal('show');
    });
}

function saveProfile(mode="save"){
    var data = getJSONString("#profileForm");
    var request = data.formObject;
    
    //if (data.files) {
        //do upload
        $fileCount=0;
        files = data.formData;
        for (var file of files.entries()){
            $.ajax({
                    type: "POST",
                    url: "utilities/upload.php?dir=upload&field="+file[0]+"&folder=profiles",
                    data: files,
                    contentType: false,
                    processData: false,
                    traditional: true,
                    success: function (result) {
                        request[file[0]] = result;
                        sendProfile(request, mode);

                    }}
            );
            $fileCount++;
        }
    //}
    if ($fileCount==0) {
        sendProfile(request, mode);
    }
}

function detachDependent(id){
    $.get("controllers/staff.php?action=detachdependent", {"id":id}, function(data, status, xhr){
        if (status=="success"){
            alert(data.message);
            $('#card-'+id).remove();
        }
    });
}

function sendProfile(request, mode){
    request.dependents = dependents;
        $.ajax({
        url:"controllers/staff.php?action="+mode+"profile",
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(request),
         success: function(result){
            $('#view').html(result.message);
         },
        error: function () {
            alert('an error occured');
        },
        complete: function () {
        }
    }
    
    );
}

function saveDependent(){
    var form = getJSONString("#dependentForm");
    var data = form.formObject;
    $.ajax({
     url:"controllers/staff.php?action=updatedependent",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function(result){
            if (result.isSuccessful) 
            {
                html="<div class=\"card\" id=\"card-${ID}\"><div class=\"card-header\">    ${dependentCode==1?\'Spouse\':\'Child\'} - <strong>${name}</strong></div> <div class=\"card-body\">   <div class=\"row\"> <div class=\"col-md-4\">Date of Birth: ${dob}</div><div class=\"col-md-4\">Gender: ${gender}</div><div class=\"col-md-4\">Email: ${email}</div>  </div>  <div class=\"row\"><div class=\"col-md-12\">    Organisaiton: ${organisation}</div>  </div>  <div class=\"row\"><div class=\"col-md-4\">Genotype: ${genotype}</div><div class=\"col-md-4\">Blood Group: ${bloodGroup}</div><div class=\"col-md-4\">Medical Conditions: ${medicalConditions}</div>  </div>   <div class=\"row\"><div class=\"col-md-12\">Hospital Details: ${hospitalName + \'. \' + hospitalAddress}</div>  </div>  </div> <div class=\"card-footer\">     <a class=\"btn btn-sm btn-info\" onclick=\"editDependent(${ID})\">Edit <i class=\"zmdi zmdi-edit\"></i></a> <a class=\"btn btn-sm btn-danger\" onclick=\"detachDependent(${ID})\">Delete <i class=\"zmdi zmdi-delete\"></i></a> </div>    </div>";
                
                var result = $.grep(dependents, function(e){ 
                 return e.ID != data.ID; 
                });
                
                dependents = result;
                dependents.push(data);
                
                tmp = $.tmpl(html, data);
                $('#card-'+data.ID).html(tmp);
                
                alert('Changes saved!');
                $('#dependentModal').modal('hide');
            }
        }
    }
    );
}

function addDependent(){
    $('#dependentModal').modal('hide');
    var data = getJSONString("#dependentForm");
    var dependent = data.formObject;
    
        if (data.files) {
        //do upload
        files = data.formData;
        for (var file of files.entries()){
            $.ajax({
                    type: "POST",
                    url: "utilities/upload.php?dir=upload&field="+file[0]+"&folder=dependents",
                    data: files,
                    contentType: false,
                    processData: false,
                    traditional: true,
                    success: function (result) {
                        dependent[file[0]] = result;
                        fillDependentGrid(dependent);
                    }}
            );
        }
    }
    else {
        fillDependentGrid(dependent);
    }
    

}

function fillDependentGrid(dependent){
    dependents.push(dependent);
    if (dependents.length==1) {
        $('#dependentGrid tbody').empty();
    }
    itemRow = "<tr><td>"+dependent.name+"</td><td><a onclick='removeItem("+(dependents.length-1)+")'>Delete</a></td></tr>";
    $('#dependentGrid tbody').append(itemRow);
    //$("#dependentAddForm").select2("val", ""); //check for reset
    $('#dependentAddForm').trigger('reset');
    //console.log(items); 
}


function login()
{
    $frm=getJSONString('#loginForm');
    var formObject = $frm.formObject;
    $.ajax({
        url:"controllers/user.php?action=login&do=Y",
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(formObject),
         success: function(result){
            if (result.isSuccessful){
                //dismiss modal
                $('#loginModal').modal('hide');
            } else {
                //login failed
                $('#login-msg').html('<p>Login failed, please provide the correct details required.</p>');
            }
         },
        error: function () {
            alert('something went wrong');
        },
        complete: function () {
        }
     }); 
}

function mapError(){
    alert('an error occured');
}

var mapOption = {
  enableHighAccuracy: true,
  timeout: 5000,
  maximumAge: 0
};

function clock($dir){
    
  navigator.geolocation.getCurrentPosition(function(position) {
    y = position.coords.latitude;
    x = position.coords.longitude;
    console.log(x, y);
    $data = $('#more_info').val();
    //post depending on the direction
    $.get("controllers/user.php?action=clock&dir="+$dir+"&data="+$data, 
          function(data, status, xhr){
            if (status=="success") {
                //update view
                if (data.isSuccessful) {alert('Clocked '+$dir);} else {alert(data.message);}
                
                
            } else {
                alert('Oops, something went wrong!');
            }
    });
  }, mapError, mapOption);
    //$action = $dir==0?"clockOut":"clockIn";
}
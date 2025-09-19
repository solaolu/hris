
var educationalInfo=[];
var referenceInfo=[];
var workExperience=[];

function addApplicationItem($item){
    var modal = "#"+$item+'Modal';
    var form = "#"+$item+"Form";
    var grid = "#"+$item+"Grid";
    
    $(modal).modal('hide');
    var data = getJSONString(form);
    var item = data.formObject;
    //var itemName = $('#items option:selected').text();
    
    //upload files if required
    if (data.files) {
        //do upload
        files = data.formData;
        for (var file of files.entries()){
            $.ajax({
                    type: "POST",
                    url: "utilities/upload.php?dir=upload&field="+file[0]+"&folder=applications",
                    data: files,
                    contentType: false,
                    processData: false,
                    traditional: true,
                    success: function (result) {
                        item[file[0]] = result;
                        fillGrid($item, item);

                    }}
            );
        }
    }
    else {
        fillGrid($item, item);
    }
    
    //console.log(eval($item));
}

function fillGrid($item, item){
    var modal = "#"+$item+'Modal';
    var form = "#"+$item+"Form";
    var grid = "#"+$item+"Grid";
    
    eval($item).push(item);
    var itemCount = eval($item).length;
    var id = itemCount - 1;
    
    if (itemCount==1) {
        $(grid).find('tbody').empty();
    }
    
    // console.log(item);
    
    switch ($item){
        case "workExperience":
            itemRow = "<tr><td>"+item.companyName+"</td><td>"+item.startDate+"</td><td>"+item.endDate+"</td><td>"+item.contactName+"</td><td>"+item.contactEmail+"</td><td>"+item.contactPhoneNo+"</td><td><a onclick=removeItem(\'"+$item+"\',"+id+")>Delete</a></td></tr>";
            break;
        case "referenceInfo":
            itemRow = "<tr><td>"+item.refereeName+"</td><td>"+item.company+"</td><td>"+item.residentialAddress+"</td><td>"+item.refereePhoneNo+"</td><td>"+item.refereeEmail+"</td><td><a onclick=removeItem(\'"+$item+"\', "+id+")>Delete</a></td></tr>";
            break;
        case "educationalInfo":
            itemRow = "<tr><td>"+item.schoolAttended+"</td><td>"+item.qualification+"</td><td>"+item.certification+"</td><td><a onclick=removeItem(\'"+$item+"\', "+id+")>Delete</a></td></tr>";
            break;
            
    }
    
    //console.log(eval($item));
    $(grid).find('tbody').append(itemRow);
    $(form).trigger('reset');
}


function removeItem($item, $id){
   // alert("Delete item - "+$id+" from '"+$item+"'");
}


/*function registerSupplier(){
    var formData = getJSONString("#supplierRegistrationForm");
    var request = formData.formObject;
    
    if (formData.files) {
        //do upload
        data = formData.formData;
        $.ajax({
                type: "POST",
                url: "utilities/upload.php?dir=upload&field="+data.name+"&folder=suppliers",
                data: data,
                contentType: false,
                processData: false,
                traditional: true,
                success: function (result) {
                    request[data.name] = result;
                    postSupplierData(request);
                }}
        );
    } 
    else {   
        postSupplierData(request);
    }
}*/

function submitJobApplication() {
    var formData = getJSONString("#jobApplicationForm");
    var request = formData.formObject;
    
    request.educationalInfo = educationalInfo;
    request.referenceInfo = referenceInfo;
    request.workExperience = workExperience;
    
    console.log(request);
    
    $.ajax({
        url:"controllers/public.php?action=apply&do=true",
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


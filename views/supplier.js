
var supplierBank=[];
var supplierExperience=[];
var supplierCapability=[];
var supplierSales=[];
var supplierReference=[];

function addSupplierItem($item){
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
                    url: "utilities/upload.php?dir=upload&field="+file[0]+"&folder=suppliers",
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
    
    switch ($item){
        case "supplierBank":
            itemRow = "<tr><td>"+item.bankName+"</td><td>"+item.bankAddress+"</td><td>"+item.bankAccountNo+"</td><td><a onclick=removeSupplierItem(\'"+$item+"\',"+id+")>Delete</a></td></tr>";
            break;
        case "supplierExperience":
            itemRow = "<tr><td>"+item.organisation+"</td><td>"+item.value+"</td><td>"+item.year+"</td><td>"+item.suppliedGood+"</td><td><a onclick=removeSupplierItem(\'"+$item+"\', "+id+")>Delete</a></td></tr>";
            break;
        case "supplierCapability":
            itemRow = "<tr><td>"+item.service+"</td><td>"+item.description+"</td><td>"+item.authorizedAgent+"</td><td><a onclick=removeSupplierItem(\'"+$item+"\', "+id+")>Delete</a></td></tr>";
            break;
        case "supplierSales":
            itemRow = "<tr><td>"+item.service+"</td><td>"+item.company+"</td><td>"+item.contactPerson+"</td><td><a onclick=removeSupplierItem(\'"+$item+"\', "+id+")>Delete</a></td></tr>";
            break;
        case "supplierReference":
            itemRow = "<tr><td>"+item.companyName+"</td><td>"+item.companyAddress+"</td><td>"+item.companyPhoneNo+"</td><td><a onclick=removeSupplierItem(\'"+$item+"\', "+id+")>Delete</a></td></tr>";
            break;
            
    }
    
    console.log(eval($item));
    $(grid).find('tbody').append(itemRow);
    $(form).trigger('reset');
}


function removeSupplierItem($item, $id){
   // alert("Delete item - "+$id+" from '"+$item+"'");
}


function registerSupplier(){
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
}

function postSupplierData(request){
    request.banks = supplierBank;
    request.experience = supplierExperience;
    request.capability=supplierCapability;
    request.sales = supplierSales;
    
    //console.log(request);
    
    $.ajax({
        url:"controllers/supplier.php?action=register",
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

function sendQuote(){
    var formData=getJSONString("#briefQuoteForm");
    var data=formData.formObject;
    
    $.ajax({
        url:"controllers/supplier.php?action=quote",
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(data),
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

function getbriefs(){
    
        $.ajax({
        url:"controllers/supplier.php?action=getbriefs",
        type: "POST",
        contentType: "application/json",
         success: function(result){
             if (result.isSuccessful){
                 $tmpl = '<div class="table-responsive"><table id="data-table" class="table data-table"><thead><tr><th>Project Name</th>';
                 $tmpl +='<th>Date</th><th></th></tr></thead>';
                 $tmpl +='<tbody>{{each object}}<tr><td>&nbsp;&nbsp;${ProjectName}</td><td>${EventDate}</td><td><a href="#" onclick="openbrief(${ID})">View Details</a></td>';
                 $tmpl +='</tr>{{/each}}</tbody></table></div>';

                $.template("briefs", $tmpl);
                $('#view').html($.tmpl("briefs", result));
                 
                      $('.data-table').DataTable();
             }
         },
        error: function () {
            alert('an error occured');
        },
        complete: function () {
        }
    });
                        
}

function openbrief(id){
    var url = 'views/templates/supplier/view.php?id='+id;
    $('#view').load(url);
}
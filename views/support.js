var items = [];
function startInventoryRequest(){
    $.get("controllers/inventory.php?action=items", function(result){
        if (result.isSuccessful){
            $('#template').load("views/templates/inventory/request.html", function(){
                html = $(this).html();
                tmp = $.tmpl(html, result);
                $('#view').html(tmp);
                select2(); datepicker(); datetimepicker();
            });
        }
    });
}

function inventoryRequest(){
    
    var formData = getJSONString("#inventoryRequestForm");
    var request = formData.formObject;
    request.items = items;
    
    //console.log(request);
    
    $.ajax({
        url:"controllers/inventory.php?action=requestItem",
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

function addItem(){
    
    var data = getJSONString("#itemAddForm");
    var item = data.formObject;
    var itemName = $('#items option:selected').text();
    var itemQtyAvail = $('#items option:selected').data('count');
    var itemQtyReq = $('#itemQty').val();
    if (itemQtyReq <= itemQtyAvail)
        {
                $('#itemModal').modal('hide');
                items.push(item);
                if (items.length==1) {
                    $('#itemsGrid tbody').empty();
                }
                itemRow = "<tr><td>"+itemName+"</td><td>"+item.itemQty+"</td><td>"+item.itemExpectedReturnDate+"</td><td><a onclick='removeItem("+item.itemID+")'>Delete</a></td></tr>";
                $('#itemsGrid tbody').append(itemRow);
                $("#items").select2("val", ""); //check for reset
                $('#itemAddForm').trigger('reset');
                //console.log(items);
        } else {
            alert('An error occurred while adding the requested item. Please check that the quantity of items you are requesting for are available in the store.');
        }

}

function startNewBrief(){
    $('#view').load("views/templates/support/briefs.tab.php", function(){
       select2();datepicker(); 
    });
    
}

function submitBrief(brief){
    var data = getJSONString("#"+brief);
    var details = data.formObject;
    
    $.ajax({
        url:"controllers/supplier.php?action=submitbrief&brief="+brief,
        type: "POST",
        contentType: "application/json",
         data: JSON.stringify(details),
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

function showRateCard(){
    $('#view').load("views/templates/support/ratecard.php");
}
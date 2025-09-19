
function getJSONString(formObj) {
    //var form = $(formObj).serializeArray();
    var json = {};
    json["files"] = false;
    var formObject = {};
    var input_selector = 'input, textarea, select';
    $(formObj).find(input_selector).each(
        function (i, v) {
            if (v.name != "") {
                    var val = $(this).val();
                    var type = this.type;
                    if (type != "file"){
                        if (v.type == "radio") {
                            formObject[v.name] = $(formObj).find('input[name="' + v.name + '"]:checked').val();
                        } else if (v.type == "checkbox") {
                            formObject[v.name] = $(formObj).find('input[name="' + v.name + '"]:checked').map(function () {
                                return this.value;
                            }).get().join(', ');
                        } else {
                            formObject[v.name] = (val!==null && val.constructor === Array)? val.join():val;
                        }
                        
                    } else {
                        //do ajax upload
                        json["files"] = true
                        var $dir = $(this).data('dir');
                        $(function(){
                                var data = new FormData();
                                $.each(v.files, function (j, file) {
                                    data.append(v.name, file);
                                });
                           /*var upload = $.ajax({
                                type: "POST",
                                url: "utilities/upload.php?dir="+$dir,
                                data: data,
                                contentType: false,
                                processData: false,
                                traditional: true,
                                success: function (result) {
                                    //defer.resolve(result)
                                }
                            });*/

                            //return defer.promise();
                            json["formData"] = data;
                          });
                    }
            }
        });
    
        json["formObject"] = formObject;
        return json;

}

function formatAmounts(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function datepicker(){
    $(".date-picker")[0]&&$(".date-picker").flatpickr({enableTime:!1,nextArrow:'<i class="zmdi zmdi-long-arrow-right" />',prevArrow:'<i class="zmdi zmdi-long-arrow-left" />'});
}

function datetimepicker(){
    $(".datetime-picker").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    });
}

function timepicker(){
    $(".time-picker").flatpickr({
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
});
}

function select2(){
    $('.select2').select2({dropdownAutoWidth:!0,width:"100%"});
}

function processFailedRequests(result){
    //console.log(result);
    if (result.code==401){
        alert(result.message);
        $('#loginModal').modal('show');
        //location.href='index.php';
    } 
    else {
        alert(result.message);
    }
}



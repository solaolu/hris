/*if('geolocation' in navigator)
   {
                navigator.geolocation.getCurrentPosition(position=> log(position.coords.longitude, position.coords.latitude),
                err=>alert("Something went wrong! \nTrace: "+err));
   } 
   else 
   {
            alert('Location is not supported by your browser.');                
}*/
            
function log(x, y){
    var client = new ClientJS();
    $('#more_info').val(x+':'+y+':'+client.getFingerprint());
    
    console.log(x+":"+y);
}
        
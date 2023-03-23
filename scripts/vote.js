function vote(up){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","../vote.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            var response = JSON.parse(xhr.responseText);
            if(response.success){
            }
        }
    }
    xhr.send("data=data");
}
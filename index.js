var camps;
var numbers;
$(document).ready(function(){
    getTopics();
    
    $("#submit").click(function(){
        // console.log("Button clicked");
        if (validateForm()){
            // console.log("Form validation returned true.");
            signUp();
        }
        else {
            // console.log("Form validation returned false.");
        }
    }
    );//close btn_submit.click

});//close document ready

function signUp(){
    $('#status').html('Connecting to database...');

    var first = $('#first').val();
    var last = $('#last').val();
    var camp = $('#camp').val();
    var params = 
        '&first='+first+
        '&last='+last+
        '&camp='+camp;
    // console.log(params);

    var xhr_signup = new XMLHttpRequest();
    xhr_signup.onreadystatechange = function() {
        if (xhr_signup.status == 200) {
            // console.log("XMLHttpRequest successful");
            // console.log(xhr_signup.responseText);
            $('#status').html(xhr_signup.responseText);
            getTopics();
            $('#first').val("");
            $('#last').val("");
        }
    };
    xhr_signup.open("POST", "signup.php", true);
    xhr_signup.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr_signup.send(params);
}

function getTopics(){
    document.getElementById("camp").innerHTML = "<option>Loading options...</option>";
    var xhr_camps = new XMLHttpRequest();
    var campsURL = "get_camps.php";
    xhr_camps.open("GET",campsURL, true);
    xhr_camps.onload = function(){
        if(xhr_camps.status===200){
            var camps = JSON.parse(xhr_camps.responseText);
            var xhr_numbers = new XMLHttpRequest();
            var numbersURL = "get_numbers.php";
            xhr_numbers.open("GET",numbersURL, true);
            xhr_numbers.onload = function(){
                if(xhr_numbers.status===200){
                    var numbers = JSON.parse(xhr_numbers.responseText);
                    //update the camps list
                    var output = "";
                    output += "<option value=''>Select a Summer Camp</option>";
                    for (var i = 0; i < camps.length; i++){
                        //check if it is already at or above maximum capacity
                        //Need to go through the numbers list and find the right one
                        var openings = true;
                        for (var j=0; j < numbers.length; j++){
                            if(numbers[j]['id'] == camps[i]['id']){
                                if(parseInt(numbers[j]['studentCount'])>=parseInt(camps[i]['capacity'])){
                                    openings = false;
                                    // console.log(numbers[j]['studentCount']+", "+camps[i]['capacity']);
                                    // console.log(openings);
                                }
                            }
                        }
                        if(openings){
                            output += "<option value="+camps[i]['id']+">"+camps[i]['week']+" "+camps[i]['type']+"</option>\n";
                        }
                    }
                    // console.log(output);
                    $('#camp').html(output);

                } else {
                    // console.log("XML HTTP error: "+xhr_numbers.status);
                    $('#status').html(xhr_numbers.status);
                    }
                };
            xhr_numbers.send();
        }
        else{
            $('#status').html(xhr_numbers.status);
        }
        };
    xhr_camps.send();
}

function validateForm(){
    var first = $('#first').val();     
    var last = $('#last').val();
    var grade = $('#grade').val();
    var camp = $('#camp').val();
    var parent_first = $('#parent_first').val();
    var parent_last = $('#parent_last').val();
    var phone1 = $('#phone1').val();
    var email1 = $('#email1').val();
    var agree = $('#agree').val();
    
    var alertmessage = "";
    var validated = true;
    
    if (first==""||first==null||first.length<2){
        alertmessage += "Student's first name must be entered.<br>";
        validated = false;
    }
    if (last==""||last==null||last.length<2){
        alertmessage += "Student's last name must be entered.<br>";
        validated = false;
    }

    if (camp =="" || camp == null){
        alertmessage += "Camp week/type must be selected.<br>";
        validated = false;
    }
    if (parent_first =="" || parent_first == null){
        alertmessage += "Parent first name must be entered.<br>";
        validated = false;
    }
    if (parent_last =="" || parent_last == null){
        alertmessage += "Parent last name must be entered.<br>";
        validated = false;
    }
    if (phone1 =="" || phone1 == null){
        alertmessage += "At least one phone number must be entered.<br>";
        validated = false;
    }
    if (email1 =="" || email1 == null){
        alertmessage += "At least one email must be entered.<br>";
        validated = false;
    }
    if (validated==false){
        $("#status").html("<span style=\"color:red;font-weight:bold;font-size:110%\">"+alertmessage+"</span>");
        window.scrollTo(0,document.body.scrollHeight);
    }
    if (validated){
        $("#status").html("<span style=\"color:red;font-weight:bold;font-size:110%\">"+""+"</span>");
    }
    return validated;      
}
function login_error(error){
    $('.loginbox').hide();
    $('#login-message').html(error);
    $('#login-start').show();
}

function emailSubmit(){
    var data = {}
    
    $('.loginbox').hide();
    $('#login-loading').show();
    
    email = $("#login-email").val();
    url = "AUTH/email/login/" + email
    
    data["subject"] = LOGIN_SUBJECT;
    data["message"] = LOGIN_MESSAGE;

    api( url, data, 
        function(data){
            if (data && data.success && (data.success == 1)){
                $('.loginbox').hide();
                $("#login-submitted").show();
            }else if (data && data.message){
                if (data.message == "NEW USER"){
                    $('.loginbox').hide();
                    $('#login-new').show();
                }else{ login_error(data.message); }
            }else{ login_error("UNKNOWN ERROR"); }
        },
        function(){ login_error("Unable to contact API Server.") }
    );
}

function emailRegister(){
    $('.loginbox').hide();
    $('#login-loading').show();

    var data = {}
    data["subject"] = REGISTER_SUBJECT;
    data["message"] = REGISTER_MESSAGE;

    email = $("#login-email").val();
    url = "AUTH/email/register/" + email
    
    api(url, data,
        function(data){
            if (data && data.success && (data.success == 1)){
                $('.loginbox').hide();
                $("#login-register-submitted").show();
            }else if (data && data.message){
                login_error(data.message);
            }else{
                login_error("UNKNOWN ERROR");
            }
        },
        function(){ login_error("Unable to contact API Server."); }
    );
}

$('#login-email').keypress(function(e){ if (e.keyCode == 13) emailSubmit(); });
$('#login-submit').click(emailSubmit);
$('#login-startover').click(function(){ login_error(""); });
$("#login-register").click(emailRegister);


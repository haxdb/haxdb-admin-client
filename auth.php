<?php include("config.php"); ?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <link rel="icon" href="/favicon.ico"/>

        <title><?= $_CONFIG["PAGE_TITLE"] ?></title>

        <link href="/third-party/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/third-party/flat-ui/css/flat-ui.min.css" rel="stylesheet"/>
        <link href="/third-party/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="/include/haxdb.login.css" rel="stylesheet"/>
        <script type="text/javascript" src="/include/haxdb.config.php"></script>
        <script>
            localStorage.setItem("identity","NOBODY");
            localStorage.setItem("api_key","");
        </script>
    </head>

    <body>

    <div id='login-start' class='loginbox'>
        <table>
        <tr>
        <td><input type='email' class='form-control' id='login-email' placeholder='Email Address'/></td>
        <td><img id='login-submit' src="/img/logo.png"/></td>
        </tr>
        <tr><td id='login-message' colspan=2><?= $_GET["error"] ?></td></tr>
        </table>
    </div>

    <div id='login-loading' class='loginbox'>
        <i class='fa fa-spinner fa-5x fa-fw fa-spin'></i>
    </div>

    <div id='login-submitted' class='loginbox'>
        <img class='sidelogo' src='/img/logo.png'/>
        To continue authentication,<br/> please check your email.
    </div>

    
    <div id='login-new' class='loginbox'>
        <img class='sidelogo' src='/img/logo.png'/>
        Hi, I haven't seen you before.<br/>
        Do you want to register?<br/><br/>
        <hr/>
        <button id='login-startover' class='btn btn-danger'><i class='fa fa-refresh'></i>START OVER</button>
        <button id='login-register' class='btn btn-success'><i class='fa fa-smile-o'></i>REGISTER NEW USER</button>
    </div>

    <div id='login-register-submitted' class='loginbox'>
        <img class='sidelogo' src='/img/logo.png'/>
        Please check your email to complete registration.
    </div>



    <script src="/third-party/jquery/jquery.min.js"></script>
    <script src="/third-party/bootstrap/js/bootstrap.min.js"></script>
    <script src="/include/haxdb.login.js"></script>        
    <script src="/include/haxdb.api.js"></script>

</body>

</html>



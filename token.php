<?php
include("config.php");
$token = $_GET["token"];
if (empty($token)){
    header('Location: /auth', true, 303);
    print '<meta http-equiv="Location" content="/auth">';
    print '<script> window.location = "/auth"; </script>';
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <link rel="icon" href="/favicon.ico"/>

        <title><?= $_CONFIG["PAGE_TITLE"] ?></title>
    </head>

    <body>

    <script src="/third-party/jquery/jquery.min.js"></script>
    <script src="/third-party/alertify/alertify.js"></script>
    <script src="/include/haxdb.api.js"></script>
    <script src="/include/haxdb.js"></script>

    <script>
        check_token = function (data){
            if (data && data.success && data.success==1 && data.value){
                if (data.meta && data.meta.people_name){
                    localStorage.setItem("identity", data.meta.people_name);
                }else{
                    localStorage.setItem("identity", "unknown");
                }
                localStorage.setItem("api_key", data.value);
                document.location = '/';
            }else{
                if (data && data.message){
                    document.location = "/auth?error=" + escape(data.message);
                }else{
                    document.location = "/auth?error=" + escape("Unknown Error");
                }
            }
        }


        var API_URL = "<?= $_CONFIG["API_URL"] ?>";
        var call = "AUTH/token/" + "<?= urlencode($token) ?>";
        api(call,{},check_token);
    </script>
</body>

</html>



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

        <link href="/third-party/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/third-party/flat-ui/css/flat-ui.min.css" rel="stylesheet"/>
        <link href="/third-party/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="/include/haxdb.login.css" rel="stylesheet"/>
    </head>

    <body>

    <div id='login-noapi' class='loginbox'>
        Unable to access the API.<br/><br/>
        Access to the API may be limited to certain locations or ip addresses.<br/><br/>
        <a href='/' class='btn btn-info'><i class='fa fa-refresh'></i> &nbsp;&nbsp; TRY AGAIN</a>
    </div>

    <script src="/third-party/jquery/jquery.min.js"></script>
    <script src="/third-party/bootstrap/js/bootstrap.min.js"></script>
    <script src="/include/haxdb.api.js"></script>

</body>

</html>



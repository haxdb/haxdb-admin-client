<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title><?= $_CONFIG["PAGE_TITLE"] ?></title>

    <script src="/include/haxdb.auth.js"></script>
    <link href="/third-party/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/third-party/flat-ui/css/flat-ui.min.css" rel="stylesheet"/>
    <link href="/third-party/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/third-party/alertify/alertify.css" rel="stylesheet"/>
    <link href="/include/haxdb.css" rel="stylesheet">
    <script src="/third-party/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/include/haxdb.config.php"></script>
  </head>

  <body>

    <nav id='topbar' class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href='/' class='navbar-left'><img id='logo' src='<?=$_CONFIG["PAGE_LOGO"]?>'></a>
          <a class="navbar-brand" href="#"><?= $_CONFIG["PAGE_BRAND"] ?></a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav visible-xs">
              <li><a href="https://knoxmakers.org" target='_BLANK'><span class='fa fa-fw fa-globe'></span>WEBSITE</a></li>
              <li><hr/></li>
              <li><a href="/page/people"><span class='fa fa-fw fa-group'></span>PEOPLE</a></li>
              <li><a href="/page/assets"><span class='fa fa-fw fa-wrench'></span>ASSETS</a></li>
              <li><a href="/page/lists"><span class='fa fa-fw fa-list'></span>LISTS</a></li>
              <li><a href="/page/nodes"><span class='fa fa-fw fa-cube'></span>NODES</a></li>
              <li><hr/></li>
              <li><a href="/auth"><span class='fa fa-fw fa-sign-out'></span>LOGOUT</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right hidden-xs">
            <li><a href="https://knoxmakers.org" target='_BLANK'><span class='fa fa-fw fa-globe'></span>WEBSITE</a></li>
            <li>
                <a href='#' id='haxdb-user' class='dropdown-toggle' data-toggle='dropdown'><script> document.write(localStorage.identity); </script> <b class='caret'></b></a>
                <span class="dropdown-arrow hidden-xs"></span>
                <ul class='dropdown-menu'>
                    <li><a href="/page/lists"><span class='fa fa-fw fa-list'></span>LISTS</a></li>
                    <li><a href="/page/nodes"><span class='fa fa-fw fa-cube'></span>NODES</a></li>
                    <li><a href="/auth"><span class='fa fa-fw fa-sign-out'></span>LOGOUT</a></li>
                </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid" id='main-container'>
      <div class="row" id='main-row'>
        <div id='sidebar' class="col-sm-2 col-md-2 col-lg-1 col-xl-1 hidden-xs">
            <a href="/page/people"><span class='fa fa-4x fa-group'></span>PEOPLE</a>
            <a href="/page/assets"><span class='fa fa-4x fa-wrench'></span>ASSETS</a>
            <a href="/page/lists"><span class='fa fa-4x fa-list'></span>LISTS</a>
            <a href="/page/nodes"><span class='fa fa-4x fa-cube'></span>NODES</a>
        </div>
        <div id='page' class="col-xs-12 col-sm-10 col-md-10 col-lg-11 col-xl-11">

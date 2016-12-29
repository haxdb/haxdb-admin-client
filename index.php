<?php
include("config.php");
include ("include/header.php");

$page = $_GET["page"];
if (empty($page)) $page = "people";
foreach (glob("pages/*.php") as $filename){ $_PAGES[basename($filename,".php")] = $filename; }
if (isset($_PAGES[$page])){ include($_PAGES[$page]); }

include("include/footer.php");

?> 

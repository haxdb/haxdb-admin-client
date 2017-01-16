<?php
$api_context = $_GET["arg1"];
$api_context_id = intval($_GET["arg2"]);

$api_name = "UDF";
$udf_context = "UDF";
$udf_context_id = 0;
$col_internal = "";
$col_rowid = "UDF_ID";
$_SHOW_TITLE = True;
$_EDIT_PAGE = "";
$_PAGE_NAME = $api_context;
$_ROW_NAME = "UDF_NAME";
$_DEFAULT_QUERY = "";

include("api-list.php");
?>

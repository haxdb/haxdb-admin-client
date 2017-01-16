<?php
$rowid = intval($_GET["arg1"]);

$api_name = "LIST_ITEMS";
$api_context = "LIST_ITEMS";
$api_context_id = $rowid;
$udf_context = "LIST_ITEMS";
$udf_context_id = $rowid;
$col_internal = "";
$col_rowid = "LIST_ITEMS_ID";
$_SHOW_TITLE = True;
$_EDIT_PAGE = "";
$_PAGE_NAME = "LIST_ITEMS_VALUE";
$_ROW_NAME = "LIST_ITEMS_VALUE";

$_DEFAULT_QUERY = "";

include("api-list.php");

?>

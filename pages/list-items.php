<?php

$_LISTS_ID = $_GET["arg1"];

$_API = "LIST_ITEMS";
$_API_CONTEXT = "LIST_ITEMS";
$_API_CONTEXT_ID = $_LISTS_ID;
$_API_PARENT = "LISTS";
$_API_PARENT_LINK = "/page/lists";

$_ROW_EDIT = "/page/list-item";
$_ROW_ID = "LIST_ITEMS_ID";
$_ROW_INTERNAL = "LIST_ITEMS_INTERNAL";
$_ROW_NAME = "LIST_ITEMS_VALUE";

$_TITLE = True;
$_NEW = True;
$_UDF = True;
$_UDF_LINK = "/page/udf/LIST_ITEMS/$_LISTS_ID";

$_DEFAULT_QUERY = "";

?>

<script>
var LISTS_ID = <?= $_LISTS_ID ?>;

_DATA_LIST = {
  "LISTS_ID": LISTS_ID,
};

_DATA_NEW = {
  "LISTS_ID": LISTS_ID,
};

_DATA_SAVE = {};
</script>

<?php
include("api-list.php");
?>

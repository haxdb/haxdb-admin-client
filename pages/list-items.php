<?php

$context = "LIST_ITEMS";
$context_id = intval($_GET["arg1"]);

$_COLS = array(
    "LIST_ITEMS_VALUE"        => array("ORDER" => 0.1,   "HEADER" => "VALUE",        "TYPE" => "TEXT"),
    "LIST_ITEMS_DESCRIPTION"  => array("ORDER" => 0.2,   "HEADER" => "DESCRIPTION",  "TYPE" => "TEXT"),
    "LIST_ITEMS_ORDER"        => array("ORDER" => 0.3,   "HEADER" => "ORDER",        "TYPE" => "FLOAT"),
);

$_DEFAULT_FIELDSET = array("LIST_ITEMS_VALUE", "LIST_ITEMS_DESCRIPTION");
$_DEFAULT_QUERY = "";

$_EDIT_PAGE = "";
$_ROW_NAME[0] = "LIST_ITEMS_VALUE";

$_NEW_ASK = "value";
$_NEW_ASK_DEFAULT = "NEW ITEM";

include("context-list.php");
?>

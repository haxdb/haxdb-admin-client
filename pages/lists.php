<?php

$context = "LISTS";
$context_id = 0;

$_COLS = array(
    "LISTS_NAME" => array("ORDER" => 0.1,    "HEADER" => "NAME",      "TYPE" => "TEXT"),
);

$_DEFAULT_FIELDSET = array("LISTS_NAME");
$_DEFAULT_QUERY = "";

$_EDIT_PAGE = "list-items";
$_ROW_NAME[0] = "LISTS_NAME";

$_NEW_ASK = "name";
$_NEW_ASK_DEFAULT = "NEW LIST";

include("context-list.php");
?>

<?php

$context = "ASSETS";
$context_id = 0;

$_COLS = array(
    "ASSETS_NAME"         => array("ORDER" => 0.1,    "HEADER" => "NAME",          "TYPE" => "TEXT"),
    "ASSETS_TYPE"         => array("ORDER" => 0.2,    "HEADER" => "TYPE",          "TYPE" => "TEXT"),
    "ASSETS_MANUFACTURER" => array("ORDER" => 0.3,    "HEADER" => "MANUFACTURER",  "TYPE" => "TEXT"),
    "ASSETS_MODEL"        => array("ORDER" => 0.4,    "HEADER" => "MODEL",         "TYPE" => "TEXT"),
    "ASSETS_PRODUCT_ID"   => array("ORDER" => 0.5,    "HEADER" => "PRODUCT ID",    "TYPE" => "TEXT"),
    "ASSETS_QUANTITY"     => array("ORDER" => 0.6,    "HEADER" => "QUANTITY",      "TYPE" => "INT"),
    "ASSETS_LOCATION"     => array("ORDER" => 0.7,    "HEADER" => "LOCATION",      "TYPE" => "LIST",    "LIST" => "ASSET LOCATIONS"),
    "ASSETS_DESCRIPTION"  => array("ORDER" => 0.8,    "HEADER" => "DESCRIPTION",   "TYPE" => "TEXT"),
);

$_DEFAULT_FIELDSET = array("ASSETS_NAME","ASSETS_TYPE","ASSETS_LOCATION");
$_DEFAULT_QUERY = "";

$_EDIT_PAGE = "asset";
$_ROW_NAME[0] = "ASSETS_NAME";

$_NEW_ASK = "name";
$_NEW_ASK_DEFAULT = "NEW ASSET";

include("context-list.php");
?>

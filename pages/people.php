<?php

$context = "PEOPLE";
$context_id = 0;

$_COLS = array(
    "PEOPLE_NAME_FIRST" => array("ORDER" => 0.1,    "HEADER" => "FIRST",      "TYPE" => "TEXT"),
    "PEOPLE_NAME_LAST"  => array("ORDER" => 0.2,    "HEADER" => "LAST",       "TYPE" => "TEXT"),
    "PEOPLE_EMAIL"      => array("ORDER" => 0.3,    "HEADER" => "EMAIL",      "TYPE" => "TEXT"),
    "PEOPLE_MEMBERSHIP" => array("ORDER" => 0.4,    "HEADER" => "MEMBERSHIP", "TYPE" => "LIST",    "LIST" => "MEMBERSHIPS"),
    "PEOPLE_ACTIVE"     => array("ORDER" => 0.5,    "HEADER" => "ACTIVE",     "TYPE" => "BOOL")
);

$_DEFAULT_FIELDSET = array("PEOPLE_NAME_FIRST", "PEOPLE_NAME_LAST", "PEOPLE_EMAIL", "PEOPLE_MEMBERSHIP", "PEOPLE_ACTIVE");
$_DEFAULT_QUERY = "";

$_EDIT_PAGE = "person";
$_ROW_NAME[0] = "PEOPLE_NAME_FIRST";
$_ROW_NAME[1] = "PEOPLE_NAME_LAST";

$_NEW_ASK = "email";
$_NEW_ASK_DEFAULT = "NEW@PERSON.TLD";

include("context-list.php");
?>

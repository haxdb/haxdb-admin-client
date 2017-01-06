<?php

$context = "PEOPLE";
$context_id = 0;

$_DEFAULT_FIELDSET = array("PEOPLE_ID", "PEOPLE_NAME_FIRST", "PEOPLE_NAME_LAST", "PEOPLE_EMAIL", "PEOPLE_MEMBERSHIP", "PEOPLE_ACTIVE");
$_DEFAULT_QUERY = "";

$_EDIT_PAGE = "person";
$_ROW_NAME[0] = "PEOPLE_NAME_FIRST";
$_ROW_NAME[1] = "PEOPLE_NAME_LAST";

$_NEW_ASK = "email";
$_NEW_ASK_DEFAULT = "NEW@PERSON.TLD";

include("context-list.php");
?>

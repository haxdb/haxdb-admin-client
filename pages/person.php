<?php
$rowid = intval($_GET["arg1"]);

$_API = "PEOPLE";
$_API_CONTEXT = "PEOPLE";
$_API_CONTEXT_ID = 0;
$_API_PARENT = "PEOPLE";
$_API_PARENT_LINK = "/page/people";

$_ROW_EDIT = "";
$_ROW_ID = "PEOPLE_ID";
$_ROW_INTERNAL = "";
$_ROW_NAME = "PEOPLE_NAME_FIRST.PEOPLE_NAME_LAST";

$_TITLE = False;
$_NEW = False;
$_UDF = False;
$_UDF_LINK = "";

$_DEFAULT_QUERY = "";
?>
<h5>
  <a href='<?= $_API_PARENT_LINK ?>'><?= $_API ?></a>
  &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
  <span id='PAGE-NAME'></span>
</h5>
<hr/>

<ul class = "nav nav-tabs">
    <li class="active"><a href='#'>PERSON</a></li>
    <li><a href='/page/person-rfid/<?= $rowid ?>'>RFID</a></li>
</ul>

<div class='panel panel-default'>
  <div class='panel-body'>

<?php
include("api-view.php");
?>

  </div>
</div>

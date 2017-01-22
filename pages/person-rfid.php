<?php
$rowid = $_GET["arg1"];

$_API = "PEOPLE_RFID";
$_API_CONTEXT = "PEOPLE_RFID";
$_API_CONTEXT_ID = 0;
$_API_PARENT = "PEOPLE";
$_API_PARENT_LINK = "/page/people";

$_ROW_EDIT = "";
$_ROW_ID = "PEOPLE_RFID_ID";
$_ROW_INTERNAL = "";
$_ROW_NAME = "PEOPLE_RFID_NAME";

$_TITLE = False;
$_NEW = True;
$_UDF = True;
$_UDF_LINK = "/page/udf/PEOPLE_RFID/0";

$_DEFAULT_QUERY = "";

?>

<script>
var _DATA_LIST = {
  "PEOPLE_ID": <?= $rowid ?>,
};
var _DATA_NEW = {
  "PEOPLE_ID": <?= $rowid ?>,
};
var _DATA_SAVE = {};
</script>

<h5>
  <a href='<?= $_API_PARENT_LINK ?>'><?= $_API_PARENT ?></a>
  &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
  <span id='PAGE-NAME'></span>
</h5>
<hr/>

<ul class = "nav nav-tabs">
    <li><a href='/page/person/<?=$rowid?>'>PERSON</a></li>
    <li class="active"><a href='#'>RFID</a></li>
</ul>

<div class='panel panel-default'>
  <div class='panel-body'>

<?php
include("api-list.php");
?>

  </div>
</div>

<?php
$rowid = intval($_GET["arg1"]);

$api_name = "PEOPLE";
$api_context = "PEOPLE";
$api_context_id = $rowid;
$udf_context = "PEOPLE";
$udf_context_id = 0;
$col_internal = "";
$col_rowid = "PEOPLE_ID";

$_PAGE_NAME = "PEOPLE_NAME_FIRST.PEOPLE_NAME_LAST";
$_PARENT_PAGE = "people";
?>
<h5>
  <a href='/page/<?= $_PARENT_PAGE ?>'><?= $api_name ?></a>
  &nbsp;&nbsp;&gt;&nbsp;&nbsp;
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

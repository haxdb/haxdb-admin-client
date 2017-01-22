<?php
$rowid = intval($_GET["arg1"]);

$_API = "NODES";
$_API_CONTEXT = "NODES";
$_API_CONTEXT_ID = 0;
$_API_PARENT = "NODE";
$_API_PARENT_LINK = "/page/nodes";

$_ROW_EDIT = "";
$_ROW_ID = "NODES_ID";
$_ROW_INTERNAL = "";
$_ROW_NAME = "NODES_NAME";

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

<div class='panel panel-default'>
  <div class='panel-body'>

<?php
include("api-view.php");
?>

  </div>
</div>

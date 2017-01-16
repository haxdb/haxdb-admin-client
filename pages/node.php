<?php
$rowid = intval($_GET["arg1"]);

$api_name = "NODES";
$api_context = "NODES";
$api_context_id = $rowid;
$udf_context = "NODES";
$udf_context_id = 0;
$col_internal = "";
$col_rowid = "NODES_ID";

$_PAGE_NAME = "NODES_NAME";
?>
<h5>
<a href='/page/nodes'>NODES</a>
&nbsp;&nbsp;&gt;&nbsp;&nbsp;
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

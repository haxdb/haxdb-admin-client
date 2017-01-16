<?php
$rowid = intval($_GET["arg1"]);

$api_name = "PEOPLE_RFID";
$api_context = "PEOPLE_RFID";
$api_context_id = $rowid;
$udf_context = "PEOPLE_RFID";
$udf_context_id = 0;
$col_internal = "";
$col_rowid = "PEOPLE_RFID_ID";
$_SHOW_TITLE = False;
$_PAGE_NAME = "PEOPLE_NAME_FIRST.PEOPLE_NAME_LAST";
$_ROW_NAME = "PEOPLE_RFID_NAME";
?>

<h5>
<a href='/page/people'>PEOPLE</a>
&nbsp;&nbsp;&gt;&nbsp;&nbsp;
<span id='PAGE-PARENT-NAME'></span>
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
